<script> 

function loadNumberOfCards($numberOFCardsToLoad) {
    var request = new XMLHttpRequest();
    request.open('GET', "components/card.php?cardId=" + $numberOFCardsToLoad ,true);
    request.onreadystatechange = function {
        if (request.readyState === 4 && request.status === 200) {
            var cardspage = document.getElementById("cardspage");
            $cardsToLoad = request.responseText();
            cardspage.insertAdjacentHTML('beforeend', $cardsToLoad);
        }
    }
}

handleinfinteSroll = () => {
    endOfPage = window.innerHeight + window.pageYOffset >= document.getElementById("cardspage").offsetHeight;

    if (endOfPage) {
        loadNumberOfCards(15);
    }
}

const test = () => {
    document.getElementById("cardspage").innerHTML = "test";
}

window.addEventListener("scroll",test);
</script>