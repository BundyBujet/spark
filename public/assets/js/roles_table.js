document.addEventListener("alpine:init", () => {
  Alpine.data("sorting", () => ({
    datatable: null,
    exportPlugin: null,
    columns: [
      {
        name: "Id",
        hidden: true
      },
      {
        name: "Role",
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
      let headers = this.columns.map((col) => {
        return col.name;
      });
      this.datatable = new simpleDatatables.DataTable("#myTable", {
        headings: headers,
        data: {
          headings: [
            `${Alpine.store("app").locale === "en" ? "ID" : "الممييز"}`,
            `${
              Alpine.store("app").locale === "en" ? "Role Name" : "اسم الدور"
            }`,
            `${Alpine.store("app").locale === "en" ? "Action" : "العمليات"}`
          ], // Exclude 'Action' here
          data: await getAllUsers() // Use the data fetching function
        },
        searchable: true,
        perPage: 10,
        perPageSelect: [10, 20, 30, 50, 100],
        columns: [
          {
            select: 0,
            sort: "asc"
          },
          {
            select: 1,
            render: (data, td, rowIndex, cellIndex) =>
              `<span class="badge bg-info">${data}</span>`
          },
          {
            select: 2,
            render: (data, td, rowIndex, cellIndex) => `
              
                <div class="flex gap-2">
                <a href="role?id=${data}" >
                <button type="submit" class="badge bg-success">
                  <i class="text-xl ri-eye-line"></i>
                </button>
                </a>
              
              <a href="edit-role?id=${data}" >
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
        const response = await fetch(`api/admin/delete-role`, {
          method: "POST",
          credentials: "include",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            roleId: data
          })
        });
        if (response.ok) {
          window.location.href = "/roles";
        } else {
          window.location.href = "/roles";
        }
      } catch (error) {
        window.location.href = "/roles";
      }
    }
  });
}

function openModal(data) {
  console.log(data);
  showAlert(data);
}
