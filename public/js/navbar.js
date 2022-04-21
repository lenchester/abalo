const navList = document.createElement('ul');
const navListElements = ["Home", "Kategorien", "Verkaufen", "Unternehmen", "Philosophie", "Karriere"]
for (let i = 0; i < navListElements.length; i++)
{
    let li = document.createElement('li');
    li.innerHTML = navListElements[i];
    navList.appendChild(li);

}
/*let li1 = document.createElement('li');
li1.innerHTML = "Unternehmen";
navList.appendChild(li1);

let ul1 = document.createElement('ul');

let li2 = document.createElement('li');
li2.innerHTML = "Philosophie";
let li3 = document.createElement('li');
li3.innerHTML = "Karriere";

ul1.appendChild(li2);
ul1.appendChild(li3);*/




document.body.prepend(navList);

