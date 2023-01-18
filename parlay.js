

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
            if(groups[Object.keys(groups)[i]][j].has_outrights==false){
                let li = document.createElement("button")
            
            li.value=groups[Object.keys(groups)[i]][j].key
            li.addEventListener("click",getOdds)
            li.innerHTML = groups[Object.keys(groups)[i]][j].title
            ul.appendChild(li)
            }
            
        }
    }
    // list.innerHTML = data[i].group
}

// unction eventHandler(event) {
//     if (event.type === 'fullscreenchange') {
//       /* handle a full screen toggle */
//     } else /* fullscreenerror */ {
//       /* handle a full screen toggle error */
//     }
//   }

function getOdds(event){
     console.log(event.target.value)
    const sportsOdds = fetch('https://api.the-odds-api.com/v4/sports/'+ event.target.value +'/odds/?apiKey=a556b68607a218bac43c12a29f9bdfc3&regions=eu&markets=h2h,spreads&oddsFormat=decimal')
        .then((response)=>{
            return response.json()
        }).then( (data) => {
            // console.log(data)
            oddsback(data)
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
        awayML.value = eventName.innerHTML
        homeML.value = eventName.innerHTML
        awayML.addEventListener("click",addToParlay)
        homeML.addEventListener("click",addToParlay)

        document.getElementById("Odds").appendChild(eventName)
        document.getElementById("Odds").appendChild(awayML)
        document.getElementById("Odds").appendChild(homeML)
        if(data[k].bookmakers[0].markets.length > 1){
            let awaySpread = document.createElement("button")
            let homeSpread = document.createElement("button")
            awaySpread.innerHTML = data[k].bookmakers[0].markets[1].outcomes[0].name + " " + data[k].bookmakers[0].markets[1].outcomes[0].point + ": " + data[k].bookmakers[0].markets[1].outcomes[0].price
            homeSpread.innerHTML = data[k].bookmakers[0].markets[1].outcomes[1].name + " " + data[k].bookmakers[0].markets[1].outcomes[1].point + ": " + data[k].bookmakers[0].markets[1].outcomes[1].price
            awaySpread.value = eventName.innerHTML
            homeSpread.value = eventName.innerHTML
            awaySpread.addEventListener("click",addToParlay)
            homeSpread.addEventListener("click",addToParlay)
            document.getElementById("Odds").appendChild(awaySpread)
            document.getElementById("Odds").appendChild(homeSpread)
        }
        console.log(data[k].away_team + " vs " + data[k].home_team + " " + data[k].commence_time +data[k].bookmakers[0] + ":" + data[k].bookmakers[0].markets[0].outcomes[0].name + " " + data[k].bookmakers[0].markets[0].outcomes[0].price + "vs." + data[k].bookmakers[0].markets[0].outcomes[1].name + " " + data[k].bookmakers[0].markets[0].outcomes[1].price )
    
    }
    let eventOdds = document.createElement("h1")
    // eventOdds.innerHTML += 
    // document.getElementById("Header").appendChild(eventOdds)
}


let descriptions = ""
    let prices = 1
    let events = ""
   

document.getElementById('Continue').addEventListener('click',insertBet)

function addToParlay(event){
    descriptions += ", " + event.target.textContent.split(":")[0]
    prices = prices * event.target.textContent.split(":")[1]
    events +=  ", " + event.target.value 


}


function insertBet(event){
    console.log(event)
    // const bet_amount = Number(window.prompt("How much would you like to bet",""));
    // const bet_description = event.target.textContent.split(":")[0]
    // const bet_price = event.target.textContent.split(":")[1]
    // const bet_event = event.target.value

    const bet_amount = Number(window.prompt("How much would you like to bet",""));
    const bet_description = descriptions
    const bet_price = prices
    const bet_event = events


     const betData = { 'bet_description': bet_description, 'bet_amount': bet_amount, 'bet_event': bet_event, 'bet_price': bet_price}
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

