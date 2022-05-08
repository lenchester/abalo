//const navList = document.createElement('ul');
const navListElements = [
    {
        name: "Home",
        subitems: []
    },
    {
        name:"Kategorien",
        subitems:[]
    },
    {
        name:"Verkaufen",
        subitems: []
    },
    {
        name:"Unternehmen",
        subitems:[
            {
                name:"Philosophie",
                subitems:[]
            },
            {
                name: "Karriere",
                subitems: []
            }
        ]
    }];

class navbar
{
    constructor(lst) {
        this.lst = lst;
    }

    renderList()
    {
        let outerUl = document.createElement('ul')
        for (let i = 0; i < this.lst.length; i++)
        {
            let listNode = document.createElement('li');
            listNode.innerHTML = this.lst[i].name;
            outerUl.appendChild(listNode);
            if(this.lst[i].subitems != null && this.lst[i].subitems.length != 0)
            {
                let innerUl = document.createElement('ul');
                let innerList = this.lst[i].subitems;
                for (let j = 0; j < innerList.length; j++)
                {
                    let innerListElement = innerList[j].name;
                    let innerListNode = document.createElement('li');
                    innerListNode.innerHTML = innerListElement;
                    innerUl.appendChild(innerListNode);
                }
                outerUl.appendChild(innerUl);
            }
        }
        document.body.prepend(outerUl);
        outerUl.setAttribute("id", "navbar");
    }

}

let nav = new navbar(navListElements);
nav.renderList();




//document.body.prepend(navList);

