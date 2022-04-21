var data = {
    'produkte': [
        { name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3 },
        { name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5 },
        { name: 'Robomaster' ,preis: 199.99, kategorie: 1, anzahl: 2 },
        { name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8 },
        { name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4 },
        { name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5 }
    ],
    'kategorien': [
        { id: 1, name: 'Spielzeug' },
        { id: 2, name: 'Garten' }
    ]
};

function getMaxPreis()
{
    let max = 0;
    for (let i = 0; i < data.produkte.length; i++)
    {
        let product = data.produkte[i];
        if (product.preis > max)
        {
            max = product.preis;
        }
    }
    console.log("Max price " + max);
}

function getMinPreisProdukt()
{
    let min = data.produkte[0].preis;
    let minIdx = 0;
    for (let i = 0; i < data.produkte.length; i++)
    {
        if (data.produkte[i].preis < min)
        {
            min = data.produkte[i].preis;
            minIdx = i;
        }
    }
    console.log("Cheapest product" + data.produkte[minIdx]);
}

function getPreisSum()
{
    let priceSum = 0;
    for (let i = 0; i < data.produkte.length; i++)
    {
        priceSum += data.produkte[i].preis;
    }
    console.log("Prices sum " + priceSum);
}

function getGesamtWert()
{
    let gesamtWert = 0;
    for (let i = 0; i < data.produkte.length; i++)
    {
        gesamtWert += data.produkte[i].preis * data.produkte[i].anzahl;
    }
    console.log("GesamtWert " + gesamtWert);
}

function getAnzahlProdukteOfKategorie()
{

}



getMaxPreis(data);
getMinPreisProdukt(data);
getPreisSum(data);
getGesamtWert(data);

