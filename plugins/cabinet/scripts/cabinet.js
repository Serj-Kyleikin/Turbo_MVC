//*********** Вкладки ***********//

document.querySelectorAll('.information_tab').forEach((item) => {
    item.onclick = function() {
        document.querySelector('.information_content.active').classList.remove('active');
        document.querySelector('.information_show').children[item.dataset.tab].classList.add('active');
    } 
 }); 

//*********** Сохранить настройки ***********//

async function updateInfo(name) {

    let formData = new FormData();
    let form = document.forms[name];

    for(let i = 0; i < form.length; i++) {
        if(form.elements[i].name != 'submit') formData.append(form.elements[i].name, form.elements[i].value);
    }

    formData.append('ajaxSettings', 'plugins:cabinet:save'+name);

    // Запрос на сервер

    await fetch('/Ajax.php', {
        method: 'POST',
        body: formData
    });

    document.location.href = 'cabinet';
}

//*********** Кнопки форм ***********//

async function getButton(name) {
    
    let formData = new FormData();
    
    formData.append('ajaxSettings', 'plugins:cabinet:getButton');

    formData.append('name', name);

    let sentAjax = await fetch('/Ajax.php', {
        method: 'POST',
        body: formData
    });

    let data = await sentAjax.json();

    let collection = JSON.parse(data);

    formData = null;
    createForm(collection, document.querySelector('.' + name));
    if(document.getElementById('create_' + name)) document.getElementById('create_' + name).remove();
}

function createForm(items, Main) {

    let element;
    let parents = {
        main: Main,
        block: {},
        wrapper: {},
        label: {},
        field: {},
        attribute: {},
        other: {}
    };

    let create = (item, text, parent) => {

        let type = (item == 'div' || item == 'label' || item == 'p' || item == 'hr' || item == 'input' || item == 'textarea') ? true : false;

        if(/^data/.test(item)) item = item.replace(/_/, "-");

        if(type) {
            element = document.createElement(item);
            if(text != 'no') element.textContent = text;
            parent.appendChild(element);
        } else {
            element = document.createAttribute(item);
            element.value = text;
            parent.setAttributeNode(element);
        }

        return element;
    };

    for(let a in items) {
        for(let b in items[a]) {

            let info = items[a][b].split(' + ');
            let to = info[2];
            let parrent = info[1];

            parents[to] = create(b, info[0], parents[parrent]);
        }
    }
}

async function formInfo(name) {

    let formData = new FormData();

    let items = document.querySelectorAll('.' + name.toLowerCase());

    // Последовательное выполнение ajax запросов

    for(let i = 0; i < items.length; ++i) {

        let inputs = items[i].getElementsByTagName('input');

        for(let i = 0; i < inputs.length; i++) {
            if(inputs[i].getAttribute('type') == 'file' && inputs[i].files[0] !== undefined) {
                formData.append(inputs[i].getAttribute('name'), inputs[i].files[0]);
            } else {
                formData.append(inputs[i].getAttribute('name'), inputs[i].value);
            }
        }

        let textareas = items[i].getElementsByTagName('textarea');

        for(let i = 0; i < textareas.length; i++) {
            formData.append(textareas[i].getAttribute('name'), textareas[i].value);
        }

        if(items[i].getAttribute('data-' + name.toLowerCase()) != 'new_' + name.toLowerCase()) formData.append('id', items[i].getAttribute('data-' + name.toLowerCase()));
        else formData.append('id', 'add');

        formData.append('ajaxSettings', 'plugins:cabinet:save'+name);

        await fetch('/Ajax.php', {
            method: 'POST',
            body: formData
        });
    }

    formData = null;

    document.location.href = 'cabinet';
}

//*********** Удаление созданных форм ***********//

async function deleteItem(item, name) {

    let formData = new FormData();

    if(item.parentNode.getAttribute('data-' + name) != 'new_' + name) {

        formData.append('id', item.parentNode.getAttribute('data-' + name));

        formData.append('ajaxSettings', 'plugins:cabinet:delete'+name.toUpperCase());

        await fetch('/Ajax.php', {
            method: 'POST',
            body: formData
        });

        formData = null;
        item.parentNode.remove();
        document.location.href = 'cabinet';

    } else {
        item.parentNode.remove();
    }
}