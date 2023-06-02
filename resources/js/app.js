import './bootstrap';

import toastr from 'toastr';
window.toastr = toastr;

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
