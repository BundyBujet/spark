@php
    $locale = app()->getLocale();
    $notify_dir = $locale == 'ar' ? 'top-start' : 'top-end'
@endphp
<script>
    showMessage = (
      msg = "Example notification text.",
      position = "top-start",
      color,
      showCloseButton = true,
      closeButtonHtml = "",
      duration = 3000
    ) => {
      const toast = window.Swal.mixin({
        toast: true,
        position: position || "bottom-start",
        showConfirmButton: false,
        timer: duration,
        showCloseButton: showCloseButton,
        customClass: {
          popup: `color-${color}`
        }
      });
      toast.fire({
        title: msg
      });
    };

    document.addEventListener("alpine:init", () => {
      // main section
      Alpine.data("scrollToTop", () => ({
        showTopButton: false,
        init() {
          window.onscroll = () => {
            this.scrollFunction();
          };
        },

        scrollFunction() {
          if (
            document.body.scrollTop > 50 ||
            document.documentElement.scrollTop > 50
          ) {
            this.showTopButton = true;
          } else {
            this.showTopButton = false;
          }
        },

        goToTop() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }
      }));

      // theme customization
      Alpine.data("customizer", () => ({
        showCustomizer: false
      }));

      // sidebar section - reference implementation: querySelector, no setTimeout
      Alpine.data("sidebar", () => ({
        normalizePath(path) {
          if (!path) return '';
          path = String(path);
          try {
            if (path.startsWith('http')) {
              path = new URL(path).pathname;
            }
          } catch (e) {}
          path = path.replace(/^\/(en|ar)\//, '/');
          path = path.replace(/\/$/, '');
          path = path.split('?')[0].split('#')[0];
          return path;
        },
        init() {
          const currentPath = this.normalizePath(window.location.pathname);
          const allLinks = document.querySelectorAll('.sidebar ul a[href]');

          const candidates = [];
          allLinks.forEach((link) => {
            const href = link.getAttribute('href');
            const linkPath = this.normalizePath(href);
            const isExact = linkPath === currentPath;
            const isParent = !isExact && currentPath.startsWith(linkPath + '/');

            if (isExact || isParent) {
              candidates.push({ link, linkPath, exact: isExact });
            }
          });

          const exact = candidates.find((c) => c.exact);
          const best = exact || (candidates.length ? candidates.reduce((a, b) =>
            a.linkPath.length >= b.linkPath.length ? a : b
          ) : null);

          if (best) {
            const bestMatch = best.link;
            bestMatch.classList.add('active');
            const parentLi = bestMatch.closest('li');
            if (parentLi) parentLi.classList.add('active');

            const subMenu = bestMatch.closest('ul.sub-menu');
            if (subMenu) {
              const menuGroup = subMenu.closest('li.menu');
              if (menuGroup) {
                menuGroup.classList.add('active');
                const button = menuGroup.querySelector('button.nav-link');
                if (button) button.classList.add('active');
                this.$nextTick(() => {
                  const groupData = Alpine.$data(menuGroup);
                  if (groupData && typeof groupData.isOpen !== 'undefined') {
                    groupData.isOpen = true;
                  } else if (button) {
                    button.click();
                  }
                });
              }
            }
          }
        }
      }));

      // header section
      Alpine.data("header", () => ({
        init() {
          // controll lang on inital load
          // value is derived form the template engine ejs
          const lang = "{{{app()->getLocale()}}}";
          if (lang === "en") {
            this.$store.app.toggleLocale("en");
          } else {
            this.$store.app.toggleLocale("ae");
          }
          const selector = document.querySelector(
            'ul.perfect-scrollbar a[href="' + window.location.pathname + '"]'
          );

          if (selector) {
            selector.classList.add("active");
            const ul = selector.closest("ul.sub-menu");
            if (ul) {
              let ele = ul.closest("li.menu").querySelectorAll(".nav-link");
              if (ele) {
                ele = ele[0];
                setTimeout(() => {
                  ele.classList.add("active");
                });
              }
            }
          }
        },
        languages: [
          {
            id: 1,
            key: "{{{app()->getLocale() === 'en' ? 'English' : 'الإنجليزية'}}}",
            href:
              window.location.pathname.length > 3 &&
              /\b\w*(ar|en)\w*\b/.test(window.location.pathname)
                ? window.location.pathname.replace("ar", "en")
                : "en" + window.location.pathname,
            value: "en",
            img: "{{asset("assets/images/flags/EN.svg")}}"
          },
          {
            id: 2,
            key: "{{{app()->getLocale() === 'en' ? 'Arabic' : 'العربية'}}}",
            href:
              window.location.pathname.length > 3 &&
              /\b\w*(ar|en)\w*\b/.test(window.location.pathname)
                ? window.location.pathname.replace("en", "ar")
                : "ar" + window.location.pathname,
            value: "ae",
            img: "{{asset("assets/images/flags/AE.svg")}}"
          }
        ]
      }));
      Alpine.data("accountDropdown", () => ({
        open: false,
        showMessage: false,
        message: "",
        messageClass: "",

        toggle() {
          this.open = !this.open;
        },

        async downloadAccount(type) {
          try {
            // Make the fetch request
            const response = await fetch(`/api/users/accounts?isActive=${type}`, {
              method: "GET",
              credentials: "include",
              headers: {
                "Content-Type": "application/json"
              }
            });

            if (!response.ok) {
              throw new Error("Failed to fetch the account data");
            }

            const accounts = await response.json();

            // Format cookies as a single string
            const formatCookies = (cookiesArray) => {
              return cookiesArray
                .map((cookie) => `${cookie.name}=${cookie.value}`)
                .join("; ");
            };

            // Create CSV rows
            const csvRows = accounts.map((account) => ({
              email: account?.email || "N/A",
              password: account?.password || "N/A",
              androidToken: account?.androidToken || "N/A",
              token: account?.token || "N/A",
              cookies: formatCookies(account?.cookies) || "N/A"
            }));

            // Convert to CSV format
            const csvHeader = "Email,Pass,Android,Acess,Cookies\n";
            const csvContent = csvRows
              .map(
                (row) =>
                  `${row.email},${row.password},${row.androidToken},${row.token},${row.cookies}`
              )
              .join("\n");
            const csvFile = csvHeader + csvContent;

            // Create a Blob for the CSV file
            const blob = new Blob([csvFile], { type: "text/csv" });
            const url = window.URL.createObjectURL(blob);

            // Create a download link
            const link = document.createElement("a");
            link.href = url;
            link.download = "accounts.csv";

            // Append to the body and trigger the download
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
            showMessage("Account downloaded successfully!", "top", "success");
          } catch (error) {
            // Show error message
            this.message = error.message || "Something went wrong!";
            this.messageClass = "bg-red-500 text-white";
            this.showMessage = true;
            setTimeout(() => {
              showMessage("Failed to download account data!", "top", "danger");
            }, 3000);
          }
        }
      }));
      Alpine.data("notification", () => ({
        minixNotification(msg, color, duration = 3000, position = "{{$notify_dir}}") {
          const toast = window.Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: duration,
            showCloseButton: true,
            customClass: {
              popup: `color-${color} min-w-[300px]`
            },
            target: document.getElementById(color + "-toast")
          });
          toast.fire({
            title: msg
          });
        }
      }));
      Alpine.directive("tooltip", (el, { expression }) => {
        tippy(el, {
          content: expression,
          placement: el.getAttribute("data-placement") || undefined,
          allowHTML: true,
          delay: el.getAttribute("data-delay") || 0,
          animation: el.getAttribute("data-animation") || "fade",
          theme: el.getAttribute("data-theme") || ""
        });
      });
      Alpine.magic("popovers", (el) => (message, placement) => {
        let instance = tippy(el, {
          content: message,
          placement: placement || undefined,
          interactive: true,
          allowHTML: true,
          // hideOnClick: el.getAttribute("data-dismissable") ? true : "toggle",
          delay: el.getAttribute("data-delay") || 0,
          animation: el.getAttribute("data-animation") || "fade",
          theme: el.getAttribute("data-theme") || "",
          trigger: el.getAttribute("data-trigger") || "click"
        });

        instance.show();
      });
    });
  </script>
