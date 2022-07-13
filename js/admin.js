function admin_edit(rowClass)
{
    const row = document.querySelector(rowClass);   // On stocke la ligne du tableau à modifier
    const cells = row.querySelectorAll('td');       // On stocke chaque cellule de cette ligne
    const id = row.querySelector('th');

    const buttons = document.querySelectorAll('tr button'); // On fait disparaitre les boutons des autres lignes
    buttons.forEach(element => {
        element.style.display = 'none';
    });

    const newInput = document.createElement('input');
    newInput.value = id.innerText;
    newInput.type = 'number';
    newInput.setAttribute('form', 'admin-user-form');
    newInput.setAttribute('min', '0');
    newInput.setAttribute("name", "id");
    newInput.classList.add("form-control");
    newInput.classList.add("form-control-lg");

    id.innerText = "";
    id.appendChild(newInput);

    for (i = 0; i < cells.length-1; i++){                 // On parcourt chaque cellule de la ligne à modifier       
        const tag = cellHTML(i);                    
        const newInput = document.createElement(tag);     // Création de la balise qui remplacera la cellule (type 'input' ou 'select')

        const td = document.createElement('td');

        newInput.type = cellType(i);

        if (tag === 'select'){
            if (i == 7){
                options = ['user', 'admin', 'dev'];
            } else {
                options = ['Europe', 'N-America', 'S-America', 'Asia', 'Oceania', 'Africa'];
            }

            for (k = 0; k < options.length; k++){
                newOption = document.createElement('option');
                newOption.innerText = options[k];
                newInput.appendChild(newOption);
            }

        } else {
            newInput.value = cells[i].innerText;
        }
        
        row.removeChild(cells[i]);
        
        newInput.classList.add("form-control");
        newInput.classList.add("form-control-lg");
        newInput.setAttribute("form", "admin-user-form");
        newInput.setAttribute("name", inputName(i+1));
        
        row.insertBefore(td, cells[cells.length-1]);
        td.appendChild(newInput);

        console.log(i);
        console.log(newInput.value);
    }

    // cells[cells.length-1].innerHTML = '<button type="button" class="btn btn-outline-success btn-sm">Validate</button> <button type="button" class="btn btn-outline-danger btn-sm">Dismiss</button>';

    sub = document.createElement("input");
    sub.type = "submit";
    sub.classList.add("btn", "btn-primary", "btn-sm");
    sub.style.width = "100%";
    cells[cells.length-1].appendChild(sub);
}

function cellHTML(i)
{
    switch(i)
    {
        case 7: return "select";
        case 8: return "select";
        default: return "input";
    }
}

function cellType(i)
{
    switch(i)
    {
        case 0: return "email";
        case 2: return "file";
        case 6: return "date";
        case 10: return "date";
        default: return "";
    }
}

function inputName(i)
{
    switch(i)
    {
        case 0: return "id";
        case 1: return "email";
        case 2: return "nickname";
        case 3: return "avatar";
        case 4: return "phone";
        case 5: return "first_name";
        case 6: return "last_name";
        case 7: return "birth_date";
        case 8: return "status";
        case 9: return "region";
        case 10: return "gender";
        case 11: return "creation_date";
    }
}

function admin_ban(rowClass, is_banned)
{
    const row = document.querySelector(rowClass);   // On stocke la ligne du tableau à modifier
    const cells = row.querySelectorAll('td');       // On stocke chaque cellule de cette ligne
    const id = row.querySelector('th');

    const buttons = document.querySelectorAll('tr button'); // On fait disparaitre les boutons des autres lignes
    buttons.forEach(element => {
        element.style.display = 'none';
    });

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "verifications/admin_users_ban.php";
    cells[cells.length-1].appendChild(form);

    cells[cells.length-1].querySelector('form').innerHTML = ((is_banned) ? 'Unban ' : 'Ban ') + cells[1].innerText + ' ? <input type="hidden" name="id" value="' + id.innerText + '"><button class="btn btn-outline-danger btn-sm" type="submit">' + ((is_banned) ? 'Unban' : 'Ban') + '</button>';
    cells[cells.length-1].style = "font-size: 0.8rem;text-align: center;";

    const cancel = document.createElement("button");
    cancel.innerHTML = "Annuler";
    cancel.classList.add("btn", "btn-outline-info", "btn-sm");
    cancel.type = "button";
    cancel.style = "width: auto;";
    cancel.onclick = function() {
        cells[cells.length-1].removeChild(cells[cells.length-1].querySelector('form'));
        buttons.forEach(element => {
            element.style.display = 'inline';
        });
    }
    cells[cells.length-1].querySelector('form').appendChild(cancel);
}
