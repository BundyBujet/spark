document.addEventListener("alpine:init", () => {
  Alpine.data("sorting", () => ({
    datatable: null,
    async init() {
      this.datatable = new simpleDatatables.DataTable("#myTable", {
        data: {
          headings: [
            `${
              Alpine.store("app").locale === "en"
                ? "Interest name"
                : "اسم الإهتمام"
            }`,
            `${
              Alpine.store("app").locale === "en"
                ? "Audience Size"
                : "حجم المهتمين"
            }`,
            `${Alpine.store("app").locale === "en" ? "Topic" : "الموضوع"}`,
            `${Alpine.store("app").locale === "en" ? "Path" : "المسار"}`
          ], // Exclude 'Action' here
          data: formatedGroups ?? [] // Use the data fetching function
        },
        searchable: true,
        perPage: 10,
        perPageSelect: [10, 20, 30, 50, 100],
        columns: [
          {
            select: 0,
            sort: "asc"
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
    },
    exportTable(eType) {
      var data = {
        type: eType,
        filename: "table",
        download: true
      };

      if (data.type === "csv") {
        data.lineDelimiter = "\n";
        data.columnDelimiter = ";";
      }
      this.datatable.export(data);
    }
  }));
});
