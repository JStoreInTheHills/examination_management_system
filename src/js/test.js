var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Question",
        message: "Are you Sure?",
        timeout: 20000,
        close: false,
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              console.info(button);
              console.info(e);
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              console.info(button.innerText);
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
          ],
        ],
        onClosing: function (_instance_, closedBy) {
          console.info("closedBy" + closedBy);
        },
      });
    });
  },
};
