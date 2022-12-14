// Show header theme cards on Self-Help Menu Item hover
let self_help_menu_item = document.querySelector('#menu-wellbeing_menu :nth-child(2)');;

var setTimeToHide_ID;
var timeOutValue = 300;
const headerThemesPopup = document.querySelector('.themes_popup_header');
self_help_menu_item.addEventListener('mouseover', function handleMouseOver() {
    headerThemesPopup.classList.add('show');
    if (setTimeToHide_ID) {
        window.clearTimeout(setTimeToHide_ID);
        setTimeToHide_ID = 0;
    }
});
headerThemesPopup.addEventListener('mouseover', function handleMouseOver(e) {
    if (setTimeToHide_ID) {
        window.clearTimeout(setTimeToHide_ID);
        setTimeToHide_ID = 0;
    }
});
self_help_menu_item.addEventListener('mouseout', function handleMouseOver() {
    setTimeToHide_ID = window.setTimeout(function() {
        headerThemesPopup.classList.remove('show');
    }, timeOutValue);
});
headerThemesPopup.addEventListener('mouseout', function handleMouseOver() {
    setTimeToHide_ID = window.setTimeout(function() {
        headerThemesPopup.classList.remove('show');
    }, timeOutValue);
});