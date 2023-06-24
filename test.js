const array = [
    4,
    4,
    3,
    4,
    4,
    4,
    4,
    4,
    4,
    3,
    4,
    2,
    5,
    3,
    4,
    2,
    5,
    5,
    5,
    5,
    4,
    4,
    3,
    3,
    5,
    3,
    4,
    4,
    4,
    2,
    4,
    5
       
    ]

    let count = array.filter(element => element === 1).length;
    let count2 = array.filter(element => element === 2).length;
    let count3 = array.filter(element => element === 3).length;
    let count4 = array.filter(element => element === 4).length;
    let count5 = array.filter(element => element === 5).length;

console.log(count);
console.log(count2);
console.log(count3);
console.log(count4);
console.log(count5);