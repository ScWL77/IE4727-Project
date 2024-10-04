var login_form= document.getElementById("login");
var signup_form= document.getElementById("signup");
var btn = document.getElementById("btn");

function signup(){
    login_form.style.left="-400px";
    signup_form.style.left="50px";
    btn.style.left = "110px";
}

function login(){
    login_form.style.left="50px";
    signup_form.style.left="450px";
    btn.style.left = "0px";
}

window.addEventListener('scroll', function() {
    const footer = document.querySelector('footer');
    const scrollPosition = window.innerHeight + window.scrollY;
    const documentHeight = document.documentElement.scrollHeight;

    if (scrollPosition >= documentHeight) {
        footer.classList.add('visible');
    } else {
        footer.classList.remove('visible');
    }
});