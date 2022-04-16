function sum(a,b) {
    return a + b;
}

function math(zahl1, zahl2, func){
    return func(zahl1, zahl2);
}

"use strict"
let x;
x = "Hallo Welt";
//alert(x);

console.warn("test warning!");

console.log(sum(10,15));
console.log(math(4,2, function (x, y) {return x*y;}));


console.log("array test:");
let exampl_arr = ["eins","zwei",3,4];
for(let i = 0; i < exampl_arr.length; i++){
     console.log(exampl_arr[i]);
}

console.log("array operations");
exampl_arr.push(5)
console.log(exampl_arr[4])


