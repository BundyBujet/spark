document.addEventListener('DOMContentLoaded', function () {
  const uploadbtn = document.getElementById('upload_card_image');

  uploadbtn.addEventListener('click', function (event) {
    document.getElementById('upload_card').style.display = 'none';
    document.getElementById('loader').style.display = 'block';
  });
});
