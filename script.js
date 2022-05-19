document.getElementById("btn").addEventListener('click', function(e){
    if (document.getElementById("time").value == 0){
        e.preventDefault();
        alert("You have not chosen the date to display.");
    }
});

document.getElementById("AboutMe").addEventListener('click', function(e){
    document.getElementById("name").textContent = "s3924577";
    setTimeout(function(){
        document.getElementById("name").textContent = "Nguyen Nguyen Khuong";
    }, 3000);
});