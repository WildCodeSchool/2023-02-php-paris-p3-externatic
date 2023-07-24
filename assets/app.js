import './styles/app.scss';
import './bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

const activeBtns = document.querySelectorAll('.btn.active');
activeBtns.forEach(btn => {
    btn.style.backgroundColor = '#FED32C';
});

require('bootstrap');
