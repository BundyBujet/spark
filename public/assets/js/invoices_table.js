document.addEventListener('alpine:init', () => {
  Alpine.data('sorting', () => ({
    datatable: null,
    async init() {
      this.datatable = new simpleDatatables.DataTable('#myTable', {
        data: {
          headings: [
            `${Alpine.store('app').locale === 'en' ? 'ID' : 'رقم الفاتورة'}`,
            `${
              Alpine.store('app').locale === 'en'
                ? 'Card Owner'
                : 'صاحب البطاقة'
            }`,
            `${
              Alpine.store('app').locale === 'en' ? 'Sub. Type' : 'نوع الاشتراك'
            }`,
            `${
              Alpine.store('app').locale === 'en'
                ? 'Invoice Value'
                : 'قيمة الفاتورة'
            }`,
            `${Alpine.store('app').locale === 'en' ? 'Remaining' : 'الباقي'}`,
            `${Alpine.store('app').locale === 'en' ? 'Action' : 'العمليات'}`
          ], // Exclude 'Action' here
          data: await getInvoices() // Use the data fetching function
        },
        searchable: true,
        perPage: 10,
        perPageSelect: [10, 20, 30, 50, 100],
        columns: [
          {
            select: 0,
            sort: 'asc'
          },
          // Add an extra column for 'Action' with a custom renderer
          {
            select: 5,
            render: (data, td, rowIndex, cellIndex) => `
              <div class="flex gap-2">
                <a href="invoice?id=${data}" >
                <button type="submit" class="badge bg-warning">
                  <i class="ri-eye-line"></i>
                </button>
                </a>
                <form action="api/users/invoice/${data}" method="POST" class="badge bg-danger">
                  <button type="submit" class=" bg-danger"><i class="ri-delete-bin-line"></i></button>
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
          perPage: '{select}'
        },
        layout: {
          top: '{search}',
          bottom: '{info}{select}{pager}'
        }
      });
    }
  }));
});
