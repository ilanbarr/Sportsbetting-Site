const NBA_Scores= fetch('https://api.the-odds-api.com/v4/sports/basketball_nba/scores/?daysFrom=3&apiKey=a556b68607a218bac43c12a29f9bdfc3')
        .then((response)=>{
            return response.json()
        }).then( (data) => {
            callback(data)
            console.log(data)
            
        });

function callback(data){
    console.log(data)
}

const NFL_Scores= fetch('https://api.the-odds-api.com/v4/sports/americanfootball_nfl/scores/?daysFrom=3&apiKey=a556b68607a218bac43c12a29f9bdfc3')
        .then((response)=>{
            return response.json()
        }).then( (data) => {
            callback(data)
            console.log(data)
            
        });

// document.getElementById('grade').addEventListener('click',gradeBets)


function callback(data){
    // let scores =[]
    // for(let k=0; k< data.length; k++){
    //     let scores[k] = new Object()
    //     scores[k]['id'] = data[k].id
    //     scores[k]['home_team'] = data[k].home_team
    //     scores[k]['away_team'] = data[k].away_team
    //     scores[k]['home_score'] = data[k].scores[0].score
    //     scores[k]['away_score'] = data[k].scores[0].score
    // }
    // for(int i=0;i<scores.length;i++){

    // }
    for(let k=0; k<data.length;k++){
        if(data[k].completed == true){
        console.log(data[k])
        const id = data[k].id
        const home_team = data[k].home_team
        const home_score = data[k].scores[0].score
        const away_score = data[k].scores[0].score
        const away_team = data[k].away_team
        
        const teamData = { 'away_team': away_team, 'id': id, 'home_team': home_team, 'home_score': home_score,'away_score': away_score}
    
    fetch('gradeBet.php',{
        method: "POST",
        body: JSON.stringify(teamData),
        headers: { 'content-type': 'application/json' }
    
})
        }

    }
}

