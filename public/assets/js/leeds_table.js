document.addEventListener("alpine:init", () => {
  Alpine.data("sorting", () => ({
    datatable: null,
    currentPage: null,
    totalPages: null,
    totalItems: null,
    exportPlugin: null,
    columns: [
      {
        name: "Id",
        hidden: true
      },
      {
        name: "Name",
        hidden: true
      },
      {
        name: "Phone",
        hidden: true
      },
      {
        name: "Project",
        hidden: true
      },
      {
        name: "Status",
        hidden: true
      },
      {
        name: "Socials",
        hidden: true
      },
      {
        name: "Assigned To",
        hidden: true
      },
      {
        name: "Comments",
        hidden: true
      },
      {
        name: "Created by",
        hidden: true
      },
      {
        name: "Created at",
        hidden: true
      },
      {
        name: "Action",
        hidden: true
      }
    ],
    hideCols: [],
    showCols: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    showHideColumns(col, value) {
      if (value) {
        this.showCols.push(col);
        this.hideCols = this.hideCols.filter((d) => d != col);
      } else {
        this.hideCols.push(col);
        this.showCols = this.showCols.filter((d) => d != col);
      }
      let headers = this.datatable.columns();
      headers.hide(this.hideCols);
      headers.show(this.showCols);
    },
    async init() {
      const dataFetch = await getAllLeeds();
      this.totalPages = dataFetch.totalPages;
      this.currentPage = dataFetch.page;
      this.totalItems = dataFetch.total;
      this.fetchedPage = [1];
      let headers = this.columns.map((col) => {
        return col.name;
      });
      this.datatable = new simpleDatatables.DataTable("#myTable", {
        headings: headers,
        data: {
          headings: [
            `${Alpine.store("app").locale === "en" ? "ID" : "الممييز"}`,
            `${Alpine.store("app").locale === "en" ? "Name" : "اسم الليدز"}`,
            `${Alpine.store("app").locale === "en" ? "Phone" : "رقم الهاتف"}`,
            `${Alpine.store("app").locale === "en" ? "Project" : "المشروع"}`,
            `${Alpine.store("app").locale === "en" ? "Status" : "حالة الليدز"}`,
            `${Alpine.store("app").locale === "en" ? "Socials" : "سوشيال"}`,
            `${
              Alpine.store("app").locale === "en" ? "Assigned To" : "المعين إلى"
            }`,
            `${Alpine.store("app").locale === "en" ? "Comments" : "تعليقات"}`,
            `${
              Alpine.store("app").locale === "en"
                ? "Created by"
                : "أنشئت بواسطة"
            }`,
            `${
              Alpine.store("app").locale === "en" ? "Created at" : "أنشئت في"
            }`,
            `${Alpine.store("app").locale === "en" ? "Action" : "العمليات"}`
          ], // Exclude 'Action' here
          data: dataFetch?.data // Use the data fetching function
        },
        searchable: true,
        perPage: 8,
        perPageSelect: [8, 16, 32, 64, 128],
        columns: [
          {
            select: 0,
            sort: "asc"
          },
          {
            select: 5,
            render: (data, td, rowIndex, cellIndex) => {
              if (data) {
                const { fb, phone } = JSON.parse(data);
                return `
              <div class="flex gap-2">
                <a href="https://www.facebook.com/${fb ?? ""}" target="_blank" >
                  <i class="text-xl ri-facebook-circle-fill"></i>
                </a>
                <a href="https://wa.me/${phone ?? ""}" target="_blank" >
                  <i class="text-xl ri-whatsapp-fill"></i>
                </a>
              </div>`;
              }
              return "N/A";
            }
          },
          {
            select: 7,
            render: (data, td, rowIndex, cellIndex) => {
              if (data) {
                return `
                <div>
                  <button type="submit" onclick="openCommentsModel('${data}')" class="badge bg-warning">
                    <i class="text-xl ri-chat-3-line"></i>
                  </button>
                </div>
              `;
              }
              return "N/A";
            }
          },
          {
            select: 10,
            render: (data, td, rowIndex, cellIndex) => `
            
              <div class="flex gap-2">
                <a href="leed?id=${data}" >
                  <button type="submit" class="badge bg-warning">
                    <i class="text-xl ri-pencil-fill"></i>
                  </button>
                </a>
                <button type="submit" onclick="openModal('${data}')" class="badge bg-danger"><i class="text-xl ri-delete-bin-line"></i></button>
              </div>
            
            `
          }
        ],
        firstLast: true,
        firstText:
          '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
        lastText:
          '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
        prevText:
          '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
        nextText:
          '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
        labels: {
          perPage: "{select}"
        },
        layout: {
          top: "{search}",
          bottom: "{info}{select}{pager}"
        }
      });
      this.datatable.on("datatable.page", async (page) => {
        const isPageFetched = Array.from(this.fetchedPage).includes(
          Number(page)
        );
        if (page <= this.totalPages && !isPageFetched) {
          //get the rows to insert after the current page
          const rows = this.datatable.rows();
          //assign the new page to fetchedPage for rejecting refetch
          this.fetchedPage.push(Number(page));
          //get array of data from the api
          try {
            const { data } = await getAllLeeds(page);

            if (data.length === 0 || !data) {
              this.fetchedPage.pop();
              return;
            }

            //insert action buttons for each row
            data.forEach((row) => {
              const userId = row[0];
              const ActionRow = `
              <div class="flex gap-2">
              <a href="leed?id=${userId}" >
              <button type="submit" class="badge bg-warning">
                <i class="text-xl ri-pencil-fill"></i>
              </button>
              </a>
              <button type="submit" onclick="openModal('${userId}')" class="badge bg-danger"><i class="text-xl ri-delete-bin-line"></i></button>
              </form>
              </div>
            `;
              row[row.length - 1] = ActionRow;
              const facebookId = row[5];
              if (facebookId) {
                const { fb, phone } = JSON.parse(facebookId);
                row[5] = `
                      <div class="flex gap-2">
                        <a href="https://www.facebook.com/${
                          fb ?? ""
                        }" target="_blank" >
                          <i class="text-xl ri-facebook-circle-fill"></i>
                        </a>
                        <a href="https://wa.me/${phone ?? ""}" target="_blank" >
                          <i class="text-xl ri-whatsapp-fill"></i>
                        </a>
                      </div>`;
              }
              row[7] = `<button type="submit" onclick="openCommentsModel('${userId}')" class="badge bg-warning">
                    <i class="text-xl ri-chat-3-line"></i>
                  </button>`;
              rows.add(row);
            });
          } catch (error) {
            showMessage(error.message, "top-start", "danger");
            console.log(error.message);
          }
        }
      });
      // Initialize the export plugin
      this.exportPlugin = new DataTableExportPlugin(this.datatable);
    },
    exportTable(type) {
      this.exportPlugin.exportTable({ type, filename: "my_table_export" });
    }
  }));
});

async function showAlert(data) {
  new window.Swal({
    icon: "warning",
    title:
      Alpine.store("app").locale === "en" ? "Are you sure?" : "هل أنت متأكد؟",
    confirmButtonText: true,
    text:
      Alpine.store("app").locale === "en"
        ? "You won't be able to revert this!"
        : "هذه الخطوت لا يمكن التراجع عنها!",
    showCancelButton: true,
    cancelButtonText: Alpine.store("app").locale === "en" ? "No" : "لا",
    confirmButtonText: `
      ${Alpine.store("app").locale === "en" ? "Yes" : "نعم"} 
    `,
    padding: "2em"
  }).then(async (result) => {
    if (result.value) {
      new window.Swal(
        `${Alpine.store("app").locale === "en" ? "Deleted" : "تم حذف"}!`,
        `${
          Alpine.store("app").locale === "en"
            ? "Your file has been deleted."
            : "تم حذف الملف الخاص بك"
        }`,
        "success"
      );
      try {
        const response = await fetch(`api/leeds/delete`, {
          method: "POST",
          credentials: "include",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            leedId: data
          })
        });
        if (response.ok) {
          window.location.href = "/leeds";
        } else {
          window.location.href = "/leeds";
        }
      } catch (error) {
        window.location.href = "/leeds";
      }
    }
  });
}

async function showCommentsModal(data) {
  //fetch comments
  const comments = await getComments(data);

  let templatingComments = comments
    .map((comment) => {
      return `
    <div class="flex flex-col p-3.5 space-y-4 text-white rounded bg-primary">
        <span class="overflow-auto max-h-40 text-left ltr:pr-2 rtl:pl-2">
            ${comment.comment}
        </span>
        <hr>
        <div class="flex justify-between">
          <span>
            By: 
            <span class="badge bg-warning">
              ${comment.createBy || "N/A"}
            </span>
          </span>
          <span>
            Created At:
            <span class="badge bg-warning">
              ${comment.createdAt}
            </span>
          </span>
        </div>
      </div>`;
    })
    .join("");

  new window.Swal({
    title: "Comments",
    html: `
    <div class="flex flex-col mt-4 space-y-5">
      <div class="flex overflow-auto flex-col space-y-5 max-h-56">
        ${templatingComments || "No comments on this leed"}
      </div>
    </div>`,
    showCancelButton: true,
    cancelButtonText: "Close",
    padding: "2em"
  });
  //clean up the comments
  templatingComments = "";
  return;
}

function openModal(data) {
  console.log(data);
  showAlert(data);
}

function openCommentsModel(data) {
  showCommentsModal(data);
}

async function getComments(data) {
  const response = await fetch(`api/comments?leedId=${data}`, {
    method: "GET",
    credentials: "include",
    headers: { "Content-Type": "application/json" }
  });
  if (response.ok) {
    const data = await response.json();
    const sanitizedData = data.data.map((comment) => {
      const date = new Date(comment.createdAt);
      const dateString = date.toLocaleString();
      return {
        comment: comment.comment,
        createBy: comment.createBy,
        createdAt: dateString
      };
    });
    return sanitizedData;
  } else {
    return [];
  }
}
