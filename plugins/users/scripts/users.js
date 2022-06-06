// Авторизация

async function getData(method) {

    let info;

    try {
        let response = await fetch('https://json.geoiplookup.io/'); 
        info = await response.json(); 
    } catch(error) {
        info = 'ERR_NAME_NOT_RESOLVED';
    }

    // Формирование POST

    let formData = new FormData();

    formData.append('info', JSON.stringify(info));

    let form = document.forms[0];

    formData.append('login', form.elements.login.value);
    formData.append('password', form.elements.password.value);

    formData.append('ajaxSettings', 'plugins:users:');
    formData.append('ajaxMethod', method);

    // Запрос на сервер

    let sentAjax = await fetch('/Ajax.php', {
        method: 'POST',
        body: formData
    });

    let data = await sentAjax.text();

    // Проверка данных

    if(data) {

        formData = null;

        if(data == 'wrong_Login') {

            if(document.querySelector('.wrong')) document.querySelector('.wrong').remove();

            let DIV = document.createElement('div');
            document.getElementById('login').appendChild(DIV);
            DIV.classList.add('wrong');
            DIV.textContent = 'Неверный логин!';

            password.value = '';

        } else if(/^password_/.test(data)) {

            if(document.querySelector('.wrong')) document.querySelector('.wrong').remove();

            let DIV = document.createElement('div');
            document.getElementById('password').appendChild(DIV);
            DIV.classList.add('wrong');

            let message = 'Неверный пароль! Остал';

            if(data.split('_')[1] != 'blocked') {
                message += (data.split('_')[1] == '2') ? 'ось 2 попытки' : 'ась 1 попытка';
            } else {
                message = 'Следующая попытка через 1 час!'
            }

            DIV.textContent = message;

            password.value = '';

        } else {
            document.location.href = 'cabinet';
        }
    }
}