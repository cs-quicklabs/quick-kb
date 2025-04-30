import Quill from "quill";
import "quill/dist/quill.snow.css";

const ColorClass = Quill.import('attributors/class/color');
const SizeStyle = Quill.import('attributors/style/size');
const SizeClass = Quill.import('attributors/class/size');
Quill.register(ColorClass, true);
Quill.register(SizeStyle, true);
Quill.register(SizeClass, true);


document.addEventListener("DOMContentLoaded", () => {
    const editorElement = document.getElementById('editor');
    if (editorElement) {
        window.quill = new Quill('#editor', {
            modules: { 
                toolbar: {
                    container:  '#toolbar',
                    handlers: {
                        image: function () {
                            const input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/jpeg, image/jpg, image/webp');
                            input.click();
    
                            input.onchange = () => {
                                const file = input.files[0];
    
                                // ✅ Type check
                                const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
                                if (!allowedTypes.includes(file.type)) {
                                    alert('Only PNG, JPEG, JPG, and WEBP formats are allowed.');
                                    return;
                                }
    
                                const maxSize = 1 * 1024 * 1024; // 1MB
                                if (file.size > maxSize) {
                                    alert('Image must be less than 1MB in size.');
                                    return;
                                }
    
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    const range = quill.getSelection();
                                    quill.insertEmbed(range.index, 'image', e.target.result);
                                };
                                reader.readAsDataURL(file);
                            };
                        }
                    }
                }
            },
            placeholder: 'Type your content here...',
            theme: 'snow',
        });
    }

    

    const footerElement = document.getElementById('footerQuill');
    if(footerElement){
        window.quill= new Quill('#footerQuill', {
            modules: {
                toolbar: [
                    ['bold', 'italic'],
                    ['link', 'blockquote', 'image'],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'align': ['center', 'right', 'justify'] }]
                ],
            },
            placeholder: 'Type your footer content here...',
            theme: 'snow',
        });
    }
    
});


export default {Quill};