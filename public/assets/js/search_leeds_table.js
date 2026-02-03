document.addEventListener("alpine:init", () => {
  Alpine.data("filterLeedsTable", () => ({
    form: {
      phone: "",
      status: "",
      project: "",
      assignTo: ""
    },
    errors: {},
    isFormSubmitted: false,
    filteredData: null,
    datatable: null,
    currentPage: null,
    totalPages: null,
    totalItems: null,
    exportPlugin: null,
    fetchedPage: [1],
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
        name: "Assigned To",
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
    showCols: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
    async init() {},
    validatePhone(phone) {
      return phone.length > 3;
    },
    validateLeedStatus(status) {
      return true;
    },
    validateProject(project) {
      return true;
    },
    validateAssignTo(assignTo) {
      return true;
    },
    async handleSubmit(event) {
      event.preventDefault();
      this.isFormSubmitted = true;
      if (
        this.validatePhone(this.form.phone) &&
        this.validateLeedStatus(this.form.status) &&
        this.validateProject(this.form.project) &&
        this.validateAssignTo(this.form.assignTo)
      ) {
        try {
          const filterDataResult = await this.fetchFilteredData();
          //   this.datatable.data = filterDataResult?.data; // Store returned data
          //   this.updateTable(); // Update table with new data
          this.filteredData = filterDataResult; // Store returned data
          this.totalPages = filterDataResult.totalPages;
          this.totalItems = filterDataResult.totalItems;
          this.currentPage = filterDataResult.page;
          this.updateTable(); // Update table with new data
        } catch (error) {
          showMessage(error.message, "top-start", "danger",true,"",10000);
        //   console.error("Error:", error);
        }
      }
    },
    updateTable() {
      if (this.datatable) {
        this.datatable.destroy();
        this.datatable = null;
      }
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
          data: this.filteredData?.data // Use the data fetching function
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
                const {fb,phone} = JSON.parse(data);
                return `
                      <div class="flex gap-2">
                        <a href="https://www.facebook.com/${fb??''}" target="_blank" >
                          <i class="text-xl ri-facebook-circle-fill"></i>
                        </a>
                        <a href="https://wa.me/${phone??''}" target="_blank" >
                          <i class="text-xl ri-whatsapp-fill"></i>  
                        </a>
                      </div>`;
              }
              return "N/A";
            }
          },
          {
            select: 9,
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
            const { data } = await this.fetchFilteredData(page);

            if (data.length === 0 || !data) {
              this.fetchedPage.pop();
              return;
            }

            //insert action buttons for each row
            data.forEach((row) => {
              const userId = row[0];
              const facebookId = row[5];
              if (facebookId) {
                const {fb,phone} = JSON.parse(facebookId);
                row[5] = `
                      <div class="flex gap-2">
                        <a href="https://www.facebook.com/${fb??''}" target="_blank" >
                          <i class="text-xl ri-facebook-circle-fill"></i>
                        </a>
                        <a href="https://wa.me/${phone ?? ''}" target="_blank" >
                          <i class="text-xl ri-whatsapp-fill"></i>  
                        </a>
                      </div>`;
              }
              // row[5] = "N/A";
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
              rows.add(row);
            });
          } catch (error) {
            showMessage(error.message, "top-start", "danger",true,"",10000);
            // console.log(error.message);
          }
        }
      });
      // Initialize the export plugin
      this.exportPlugin = new DataTableExportPlugin(this.datatable);
    },
    async fetchFilteredData(page = 1, perPage = 10) {
      const response = await fetch(
        `/api/leeds/search?page=${page}&perPage=${perPage}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          credentials: "include",
          body: JSON.stringify({
            phone: this.form.phone,
            status: this.form.status,
            project: this.form.project,
            assignedTo: this.form.assignTo
          })
        }
      );

      if (!response.ok) {
        const res = await response.json();
        throw new Error(res?.error);
      }

      const data = await response.json();

      return data;
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

function openModal(data) {
  showAlert(data);
}
