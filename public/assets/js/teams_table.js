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
        name: "Team Name",
        hidden: true
      },
      {
        name: "Team leader",
        hidden: true
      },
      {
        name: "Team Members",
        hidden: true
      },
      {
        name: "Created By",
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
    showCols: [0, 1, 2],
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
      const dataFetch = await getAllTeams();
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
            `${
              Alpine.store("app").locale === "en" ? "Team Name" : "اسم الفريق"
            }`,
            `${
              Alpine.store("app").locale === "en"
                ? "Team leader"
                : "المسؤول عن الفريق"
            }`,
            `${Alpine.store("app").locale === "en" ? "Members" : "الأعضاء"}`,
            `${
              Alpine.store("app").locale === "en"
                ? "Created By"
                : "تم إنشاؤها بواسطة"
            }`,
            `${
              Alpine.store("app").locale === "en"
                ? "Created at"
                : "تاريخ الإنشاء"
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
            select: 6,
            render: (data, td, rowIndex, cellIndex) => `
                  <div class="flex gap-2">
                    <a href="edit-team?id=${data}" >
                        <button type="submit" class="badge bg-warning">
                            <i class="text-xl ri-pencil-fill"></i>
                        </button>
                    </a>
                    <a href="team?id=${data}" >
                      <button type="submit" class="badge bg-secondary">
                        <i class="text-xl ri-eye-line"></i>
                      </button>
                    </a>
                  <button type="submit" onclick="openModal('${data}')" class="badge bg-danger"><i class="text-xl ri-delete-bin-line"></i></button>
                    </form>
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
            const { data } = await getAllTeams(page);

            if (data.length === 0 || !data) {
              this.fetchedPage.pop();
              return;
            }

            //insert action buttons for each row
            data.forEach((row) => {
              const userId = row[0];
              const ActionRow = `
              <div class="flex gap-2">
              <a href="edit-team?id=${userId}" >
              <button type="submit" class="badge bg-warning">
              <i class="text-xl ri-pencil-fill"></i>
              </button>
              </a>
              <a href="team?id=${userId}" >
                      <button type="submit" class="badge bg-secondary">
                        <i class="text-xl ri-eye-line"></i>
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
        const response = await fetch(`api/teams/delete`, {
          method: "POST",
          credentials: "include",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            teamId: data
          })
        });
        if (response.ok) {
          window.location.href = "/teams";
        } else {
          window.location.href = "/teams";
        }
      } catch (error) {
        window.location.href = "/teams";
      }
    }
  });
}

function openModal(data) {
  console.log(data);
  showAlert(data);
}
