window.addEventListener("DOMContentLoaded", (event) => {
  let modifyAccountButtons = document.querySelectorAll(".edit");

  console.log(modifyAccountButtons);
  modifyAccountButtons.forEach((button) => {
    console.log(parseInt(button.id));
    let modal = $(".modal-" + button.id);
    button.onclick = () => {
      // $.ajax({
      //   type: "post",
      //   //url: base_url,
      //   data: { userid: button.id },
      //   success: function (data) {
      //     console.log(data);
      //   },
      // });
      modal.show();
    };
    let modalCloseBtn = $(
      ".modal-" + button.id + " .horizontal-container .modal-cancel-btn"
    );
    console.log(modalCloseBtn);
    modalCloseBtn.click(function (e) {
      e.preventDefault();
      $(".modal-" + button.id).hide();
    });
  });
});
