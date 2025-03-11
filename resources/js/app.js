import './bootstrap';
import toastify from './utils/toastify';
import Sortable from "sortablejs";

// Attach to window for global use (optional)
window.toastify = toastify;

window.Sortable = Sortable; // Make it available globally if needed

