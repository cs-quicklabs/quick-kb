import Quill from "quill";
import "quill/dist/quill.snow.css";

const ColorClass = Quill.import('attributors/class/color');
const SizeStyle = Quill.import('attributors/style/size');
Quill.register(ColorClass, true);
Quill.register(SizeStyle, true);


document.addEventListener("DOMContentLoaded", () => {
    const editorElement = document.getElementById('editor');
    if (!editorElement) {
        console.error("Quill editor container not found!");
        return;
    }

    window.quill = new Quill('#editor', {
        modules: { toolbar: '#toolbar' },
        placeholder: 'Type your content here...',
        theme: 'snow',
    });
});


export default Quill;