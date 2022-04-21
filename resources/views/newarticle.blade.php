<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="container">
        <script>
            // function sendNewArticle(){
            //     window.location.href = '/newarticle';
            // }

            const container = document.getElementById('container');
            let form = document.createElement('form');
            let inputName = document.createElement('input');
            let inputPrice = document.createElement('input');
            let inputDesc = document.createElement('input');
            let buttonSave = document.createElement('input');

            let labelName = document.createElement('label');
            let labelPrice = document.createElement('label');
            let labelDesc = document.createElement('label');

            let textName = document.createTextNode('name: ');
            let textPrice = document.createTextNode('price: ');
            let textDesc = document.createTextNode('description: ');

            form.setAttribute('method', 'post');
            form.setAttribute('action', '/newarticle')
            inputName.setAttribute('type', 'text');
            inputName.setAttribute('id', 'article_name');
            inputDesc.setAttribute('type', 'text');
            inputDesc.setAttribute('id', 'article_desc');
            inputPrice.setAttribute('type', 'text');
            inputPrice.setAttribute('id', 'article_price');

            labelName.setAttribute('for', 'article_name');
            labelPrice.setAttribute('for', 'article_price');
            labelDesc.setAttribute('for', 'article_desc');

            labelName.appendChild(textName);
            labelPrice.appendChild(textPrice);
            labelDesc.appendChild(textDesc);

            buttonSave.setAttribute('type', 'submit');
            buttonSave.setAttribute('value', 'save');

            form.appendChild(labelName);
            form.appendChild(inputName);
            form.appendChild(labelPrice);
            form.appendChild(inputPrice);
            form.appendChild(labelDesc);
            form.appendChild(inputDesc);
            form.appendChild(buttonSave);

            container.appendChild(form);
        </script>
    </div>
</body>
</html>
