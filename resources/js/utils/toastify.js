import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

const toastify = {
    success: function (message) {
        Toastify({
            text: message,
            duration: 2000,
            close: false,
            gravity: "top",
            position: "center",
            stopOnFocus: false,
            className: `toastify toastify-success`, // Apply custom class
            style: {
                background: "#ffffff", // White background
                color: "#000000", // Black text
            }
        }).showToast();
    },
    error: function (message) {
        Toastify({
            text: message,
            duration: 2000,
            close: false,
            gravity: "top",
            position: "center",
            stopOnFocus: false,
            className: `toastify toastify-error`, // Apply custom class
            style: {
                background: "#ffffff", // White background
                color: "#000000", // Black text
            }
        }).showToast();
    }
};

export default toastify;
