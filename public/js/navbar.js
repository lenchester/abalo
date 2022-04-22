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

function renderList(lst)
{
    let outerUl = document.createElement('ul')
    for (let i = 0; i < lst.length; i++)
    {
        let listNode = document.createElement('li');
        listNode.innerHTML = lst[i].name;
        outerUl.appendChild(listNode);
        if(lst[i].subitems != null && lst[i].subitems.length != 0)
        {
            let innerUl = document.createElement('ul')
            let innerList = lst[i].subitems;
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
}

renderList(navListElements);




//document.body.prepend(navList);

