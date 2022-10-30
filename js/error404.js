timer = document.getElementById('timer');
timeLeft = 3;
timer.innerHTML = timeLeft;

setInterval(function() 
{
    if(timeLeft <= 1)
    {
        window.location.replace("http://localhost");
    }
    timeLeft-=1;
    timer.innerHTML = timeLeft;
}, 1000);