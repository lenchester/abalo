<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id = "error"></div>
    <div id="container">
        <script>
            // function sendNewArticle(){
            //     window.location.href = '/newarticle';
            // }
            function validateForm(e) {
                const name = document.getElementById('article_name');
                const price = document.getElementById('article_price');
                const errorElement = document.getElementById('error');
                let messages = [];

                if (name.value === '' || name.value == null){
                    messages.push('name is required');
                }

                if(price.value === '' || price.value == null){
                    messages.push('price must be greater than 0');
                }

                console.log(messages);
                if(messages.length > 0){
                    e.preventDefault();
                    errorElement.innerText = messages.join(', ');
                }


            }

            const container = document.getElementById('container');
            let form = document.createElement('form');

            let inputName = document.createElement('input');
            let inputPrice = document.createElement('input');
            let inputDesc = document.createElement('input');
            let buttonSave = document.createElement('button');


            let labelName = document.createElement('label');
            let labelPrice = document.createElement('label');
            let labelDesc = document.createElement('label');

            let textName = document.createTextNode('name: ');
            let textPrice = document.createTextNode('price: ');
            let textDesc = document.createTextNode('description: ');
            let textButton = document.createTextNode('save');

            form.setAttribute('method', 'post');
            form.setAttribute('action', '/newarticle');
            form.setAttribute('name', 'myform');

            inputName.setAttribute('type', 'text');
            inputName.setAttribute('name', 'article_name');
            inputName.setAttribute('id', 'article_name');
            inputDesc.setAttribute('type', 'text');
            inputDesc.setAttribute('name', 'article_desc');
            inputPrice.setAttribute('type', 'text');
            inputPrice.setAttribute('name', 'article_price');
            inputPrice.setAttribute('id', 'article_price');

            labelName.setAttribute('for', 'article_name');
            labelPrice.setAttribute('for', 'article_price');
            labelDesc.setAttribute('for', 'article_desc');

            labelName.appendChild(textName);
            labelPrice.appendChild(textPrice);
            labelDesc.appendChild(textDesc);

            buttonSave.setAttribute('type', 'submit');
            //buttonSave.setAttribute('value', 'save');
            buttonSave.appendChild(textButton);


            form.appendChild(labelName);
            form.appendChild(inputName);
            form.appendChild(labelPrice);
            form.appendChild(inputPrice);
            form.appendChild(labelDesc);
            form.appendChild(inputDesc);
            form.appendChild(buttonSave);
            form.addEventListener('submit', validateForm);

            container.appendChild(form);
        </script>
    </div>
</body>
</html>
