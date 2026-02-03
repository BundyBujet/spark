class DataTableExportPlugin {
  constructor(dataTable) {
    this.dataTable = dataTable;
  }

  exportTable({
    type = "csv",
    filename = "table",
    download = true,
    options = {}
  }) {
    const exportHandlers = {
      csv: this.exportCSV,
      excel: this.exportExcel,
      pdf: this.exportPDF,
      print: this.printTable
    };

    if (exportHandlers[type]) {
      exportHandlers[type].call(this, { filename, download, ...options });
    } else {
      console.error(`Unsupported export type: ${type}`);
    }
  }

  extractTableData() {
    const headings = Array.from(this.dataTable.activeHeadings).map(
      (h) => h?.innerText || "N/A"
    );
    const rows = Array.from(this.dataTable.activeRows).map((row) => {
      const cells = Array.from(row.cells);
      return cells.map((cell) => cell?.data || "N/A");
    });
    return { headings, rows };
  }

  exportCSV({
    filename,
    download,
    lineDelimiter = "\n",
    columnDelimiter = ","
  }) {
    const { headings, rows } = this.extractTableData();

    const csvContent = [
      headings.join(columnDelimiter),
      ...rows.map((row) => row.join(columnDelimiter))
    ].join(lineDelimiter);

    if (download) {
      this.downloadFile(csvContent, `${filename}.csv`, "text/csv");
    }
  }

  exportExcel({ filename, download }) {
    const { headings, rows } = this.extractTableData();

    // Prepare data for SheetJS
    const sheetData = [headings, ...rows]; // Combine headings and rows
    const worksheet = XLSX.utils.aoa_to_sheet(sheetData); // Convert to Excel sheet
    const workbook = XLSX.utils.book_new(); // Create a new workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1"); // Append the sheet

    // Generate the Excel file
    const excelBuffer = XLSX.write(workbook, {
      bookType: "xlsx",
      type: "array"
    });

    if (download) {
      this.downloadFile(
        excelBuffer,
        `${filename}.xlsx`,
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
      );
    }
  }

  exportPDF({ filename, download }) {
    const { headings, rows } = this.extractTableData();

    const doc = new jspdf.jsPDF();

    // Add a title (optional)
    doc.text("Table Export", 14, 10);

    // Add table using jsPDF-autotable
    doc.autoTable({
      head: [headings], // Table headers
      cellWidth: 8, // Wrap text
      body: rows, // Table rows
      startY: 20, // Start position
      useCss: true,
      theme: "striped",
      headStyles: { font: "Amiri-Regular" }, // For Arabic text in the table head
      bodyStyles: { font: "Amiri-Regular" } // For Arabic text in the table body
    });

    if (download) {
      doc.save(`${filename}.pdf`);
    }
  }

  printTable() {
    const { headings, rows } = this.extractTableData();

    const tableHTML = `
      <html>
        <head>
          <title>Table Print</title>
          <style>
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
          </style>
        </head>
        <body>
          <h2>Exported Table</h2>
          <table>
            <thead>
              <tr>${headings.map((h) => `<th>${h}</th>`).join("")}</tr>
            </thead>
            <tbody>
              ${rows
                .map(
                  (row) =>
                    `<tr>${row.map((cell) => `<td>${cell}</td>`).join("")}</tr>`
                )
                .join("")}
            </tbody>
          </table>
        </body>
      </html>
    `;

    const newWindow = window.open("", "_blank");
    newWindow.document.write(tableHTML);
    newWindow.document.close();
    newWindow.print();
  }

  downloadFile(content, filename, mimeType) {
    const blob = new Blob([content], { type: mimeType });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
}

window.DataTableExportPlugin = DataTableExportPlugin;
