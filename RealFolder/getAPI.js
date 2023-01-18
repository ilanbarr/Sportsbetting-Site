

let sportsdata;
let cfl = {};
const sports = fetch('https://api.the-odds-api.com/v4/sports/?apiKey=a556b68607a218bac43c12a29f9bdfc3')
        .then((response)=>{
            return response.json()
        }).then( (data) => {
            callback(data)
            
        });




function callback(data){
    console.log(data)
    let groups = {}
    for(let i=0; i< data.length; i++){
        
        if (Object.keys(groups).includes(data[i].group)){
            groups[data[i].group].push(data[i])
        }
        else {
            groups[data[i].group] = []
            groups[data[i].group].push(data[i])
        }
       
        
       
        
    }console.log(groups)


    for(let i=0; i< Object.keys(groups).length; i++){
        let groupName = document.createElement("h1")
        groupName.innerHTML=Object.keys(groups)[i]
        document.getElementById('Header').appendChild(groupName)
        let ul = document.createElement("ul")
        document.getElementById('Header').appendChild(ul)
        for(let j=0; j< groups[Object.keys(groups)[i]].length;j++){
            let li = document.createElement("button")
            li.value=groups[Object.keys(groups)[i]][j].key
            if(groups[Object.keys(groups)[i]][j].has_outrights==true){
                li.addEventListener("click",getOddsFutures)
            }else{
                li.addEventListener("click",getOdds)
            }
            li.innerHTML = groups[Object.keys(groups)[i]][j].title
            ul.appendChild(li)
        }
    }

}


function getOdds(event){
     console.log(event.target.value+"00000304320430240230402340020243")
    const realValue = event.target.value
    const sportsOdds = fetch('https://api.the-odds-api.com/v4/sports/'+ realValue +'/odds/?apiKey=a556b68607a218bac43c12a29f9bdfc3&regions=eu&markets=h2h,spreads&oddsFormat=decimal')
        .then((response)=>{
            return response.json()
        }).then( (data) => {
            // console.log(data)
            oddsback(data)
        });
    }
    function getOddsFutures(event){
        console.log(event.target.value)
        const realValue = event.target.value
        const sportsOdds = fetch('https://api.the-odds-api.com/v4/sports/'+ realValue +'/odds/?apiKey=a556b68607a218bac43c12a29f9bdfc3&regions=eu&markets=outrights&oddsFormat=decimal')
           .then((response)=>{
               return response.json()
           }).then( (data) => {
               // console.log(data)
               oddsbackFutures(data)
           });
       }



  

function oddsback(data){
    console.log(data)
     let games = {}

    for(let k=0; k< data.length; k++){
        let eventName = document.createElement("h1")
        eventName.innerHTML = data[k].away_team + " vs " + data[k].home_team + " " + data[k].commence_time
        let awayML = document.createElement("button")
        let homeML = document.createElement("button")
        awayML.innerHTML = data[k].bookmakers[0].markets[0].outcomes[0].name + "ML : " + data[k].bookmakers[0].markets[0].outcomes[0].price
        homeML.innerHTML = data[k].bookmakers[0].markets[0].outcomes[1].name + "ML : " + data[k].bookmakers[0].markets[0].outcomes[1].price
        awayML.value = eventName.innerHTML + ";;;" + data[k].id
        homeML.value = eventName.innerHTML + ";;;" + data[k].id
        awayML.addEventListener("click",insertBet)
        homeML.addEventListener("click",insertBet)

        document.getElementById("Odds").appendChild(eventName)
        document.getElementById("Odds").appendChild(awayML)
        document.getElementById("Odds").appendChild(homeML)
        if(data[k].bookmakers[0].markets.length > 1){
            let awaySpread = document.createElement("button")
            let homeSpread = document.createElement("button")
            awaySpread.innerHTML = data[k].bookmakers[0].markets[1].outcomes[0].name + " " + data[k].bookmakers[0].markets[1].outcomes[0].point + ": " + data[k].bookmakers[0].markets[1].outcomes[0].price
            homeSpread.innerHTML = data[k].bookmakers[0].markets[1].outcomes[1].name + " " + data[k].bookmakers[0].markets[1].outcomes[1].point + ": " + data[k].bookmakers[0].markets[1].outcomes[1].price
            awaySpread.value = eventName.innerHTML + ";;;" + data[k].id
            homeSpread.value = eventName.innerHTML + ";;;" + data[k].id
            console.log("THIS IS HOME ID" + data[k].id)
            awaySpread.addEventListener("click",insertBet)
            homeSpread.addEventListener("click",insertBet)
            document.getElementById("Odds").appendChild(awaySpread)
            document.getElementById("Odds").appendChild(homeSpread)
        }
        console.log(data[k].away_team + " vs " + data[k].home_team + " " + data[k].commence_time +data[k].bookmakers[0] + ":" + data[k].bookmakers[0].markets[0].outcomes[0].name + " " + data[k].bookmakers[0].markets[0].outcomes[0].price + "vs." + data[k].bookmakers[0].markets[0].outcomes[1].name + " " + data[k].bookmakers[0].markets[0].outcomes[1].price )

    }
    let eventOdds = document.createElement("h1")

}

function oddsbackFutures(data){
    console.log(data)
     let games = {}
     let eventName = document.createElement("h1")
     document.getElementById("Odds").appendChild(eventName)
     eventName.innerHTML = data[0].sport_title + data[0].commence_time
    for(let k=0; k< data[0].bookmakers[0].markets[0].outcomes.length; k++){
       
        
        let teamOdds = document.createElement("button")

        teamOdds.innerHTML = data[0].bookmakers[0].markets[0].outcomes[k].name + ": " + data[0].bookmakers[0].markets[0].outcomes[k].price
        teamOdds.value = data[0].bookmakers[0].markets[0].outcomes[k].name
        
        teamOdds.addEventListener("click",insertBet)

       
        document.getElementById("Odds").appendChild(teamOdds)
        
        //console.log(data[k].away_team + " vs " + data[k].home_team + " " + data[k].commence_time +data[k].bookmakers[0] + ":" + data[k].bookmakers[0].markets[0].outcomes[0].name + " " + data[k].bookmakers[0].markets[0].outcomes[0].price + "vs." + data[k].bookmakers[0].markets[0].outcomes[1].name + " " + data[k].bookmakers[0].markets[0].outcomes[1].price )

    }
    let eventOdds = document.createElement("h1")
    // eventOdds.innerHTML += 
    // document.getElementById("Header").appendChild(eventOdds)
}

function insertBet(event){
    console.log(event)
    const bet_amount = Number(window.prompt("How much would you like to bet",""));
    const bet_description = event.target.textContent.split(":")[0]
    const bet_price = event.target.textContent.split(":")[1]
    const bet_event = event.target.value.split(";;;")[0]
    const event_id = event.target.value.split(";;;")[1]


     const betData = { 'bet_description': bet_description, 'bet_amount': bet_amount, 'bet_event': bet_event, 'bet_price': bet_price,'event_id': event_id}
     console.log(betData)
    fetch('makeBet.php',{
        method: "POST",
        body: JSON.stringify(betData),
        headers: { 'content-type': 'application/json' }
      })
    
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(err => console.error(err));
}


