document.getElementById("libraryForm").addEventListener("submit", function(e) {
    
    const username = document.querySelector("[name='username']").value;
    const ticket = document.querySelector("[name='ticket']").value;
    const genre = document.querySelector("[name='genre']").value;
    const ebook = document.querySelector("[name='ebook']").checked ? "да" : "нет";
    const period = document.querySelector("[name='period']").value;
    
    alert("Вы ввели:\nИмя: " + username + "\nНомер билета: " + ticket + "\nЖанр: " + genre + "\nЭлектронная: " + ebook + "\nСрок: " + period);
});