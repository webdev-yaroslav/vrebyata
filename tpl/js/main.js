function myFunction(x) {
    x.classList.toggle("change");
}

$(document).ready(function(){

    function menuScrollAfter() {
        if($('html').scrollTop() > 100){
            $('.menu-section').addClass('active');
        }else {
            $('.menu-section').removeClass('active');
        }
    }
    $(window).on('scroll', function(){
        menuScrollAfter();
    });
    menuScrollAfter();

})

var swiper = new Swiper(".aboutSwiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    loop: true,
    grabCursor: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

$(document).ready(function() {
    $('.tabs__item').click(function(e) {
        e.preventDefault();

        $('.tabs__item').removeClass('tabs__item-active');
        $('.tabs__block').removeClass('tabs__block-active');

        $(this).addClass('tabs__item-active');
        $($(this).attr('href')).addClass('tabs__block-active');
    });

    $('.tabs__item:first').click();
})

function send(event, php){
    console.log("Отправка запроса");
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
    var req = new XMLHttpRequest();
    req.open('POST', php, true);
    req.onload = function() {
        if (req.status >= 200 && req.status < 400) {
        json = JSON.parse(this.response);
            console.log(json);
            
            // ЗДЕСЬ УКАЗЫВАЕМ ДЕЙСТВИЯ В СЛУЧАЕ УСПЕХА ИЛИ НЕУДАЧИ
            if (json.result == "success") {
                // Если сообщение отправлено
                form.reset();
                alert("Сообщение отправлено");
            } else {
                // Если произошла ошибка
                alert("Ошибка. Сообщение не отправлено");
            }
        // Если не удалось связаться с php файлом
        } else {alert("Ошибка сервера. Номер: "+req.status);}}; 
    
    // Если не удалось отправить запрос. Стоит блок на хостинге
    req.onerror = function() {alert("Ошибка отправки запроса");};
    req.send(new FormData(event.target));
}

var modal = document.getElementById('modal01');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}