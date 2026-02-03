document.querySelectorAll(".profile_action").forEach((button) => {
  button.addEventListener("click", (e) => {
    // Disable the clicked button and hide it
    e.target.disabled = true;
    e.target.style.display = "none";

    // Find the closest loader button and show it
    const loader = e.target.closest("div").querySelector(".loader");
    if (loader) {
      loader.style.display = "block";
    }

    console.log("clicked");
  });
});
async function showAlert() {
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
    confirmButtonText: `\<a href="api/users/deleteAllTokens" class="btn btn-primary"> ${
      Alpine.store("app").locale === "en" ? "Yes" : "نعم"
    } \</a>`,
    padding: "2em"
  }).then((result) => {
    if (result.value) {
      new window.Swal("Deleted!", "Your file has been deleted.", "success");
    }
  });
}
