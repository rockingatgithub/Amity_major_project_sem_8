let moistureChart, phChart, temperaturemyChart, luxmyChart;
let all_data;

const link_div = document.getElementById("download-div");
const link = document.getElementById("download");
const button = document.getElementById("generate");

function createMoistureGraph(){
    const moisture = document.getElementById('moisture').getContext('2d');
    moistureChart = new Chart(moisture, {
        type: 'line',
        data:{
            labels: [],
            datasets:[
                {
                    label: "pulse rate",
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "red" 
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
}

function createPHGraph(){
    const ph = document.getElementById('ph').getContext('2d');
    phChart = new Chart(ph, {
        type: 'line',
        data:{
            labels: [],
            datasets:[
                {
                    label: "Heart rate",
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "green" 
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
}

function createTemperatureGraph(){
    const temperature = document.getElementById('temperature').getContext('2d');
    temperaturemyChart = new Chart(temperature, {
        type: 'line',
        data:{
            labels: [],
            datasets:[
                {
                    label: "Temperature (Celsius)",
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "orange" 
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
}


function createIntensityGraph(){
    const lux = document.getElementById('lux').getContext('2d');
    luxmyChart = new Chart(lux, {
        type: 'line',
        data:{
            labels: [],
            datasets:[
                {
                    label: "Gyroscope",
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "blue" 
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
}

function updateGraph(moisture_array, ph_array, temperature_array, intensity_array, timestamp_array){
    moistureChart.data.datasets[0].data = moisture_array;
    moistureChart.data.labels = timestamp_array;
    moistureChart.update();

    phChart.data.datasets[0].data = ph_array;
    phChart.data.labels = timestamp_array;
    phChart.update();

    temperaturemyChart.data.datasets[0].data = temperature_array;
    temperaturemyChart.data.labels = timestamp_array;
    temperaturemyChart.update();

    luxmyChart.data.datasets[0].data = intensity_array;
    luxmyChart.data.labels = timestamp_array;
    luxmyChart.update();

    document.getElementById('loading').style.display="none";
    document.getElementById('graph').style.display="block";
}
function updateHeading(first, last, length){
    const dateHTML = document.getElementById("date");
    const first_date = new Date(first * 1000);
    const last_date = new Date(last * 1000);
    
    dateHTML.innerHTML = `Date (Range): ${first_date.toDateString() } to ${last_date.toDateString()} (INDIA)<br/>
    Time(Range): ${first_date.toTimeString().split(" ")[0]} to ${last_date.toTimeString().split(" ")[0]}`;
    document.getElementById('current_data_length').innerHTML = `Current data length: ${length}`;
}
function processFetchedData(data){
    let moisture_array = [];
    let ph_array = [];
    let intensity_array = [];
    let temperature_array = [];
    let timestamp_array = [];

    let i = data.length - 20;
    if( i < 0) i = 0;
    for( ; i < data.length; i++){
        ph_array.push(data[i].value2) ;  // Heart rate
        moisture_array.push(data[i].value5); // pulse rate
        intensity_array.push(data[i].value6); // gyroscope
        temperature_array.push(data[i].value1); // Temperature
        
        let d = new Date(data[i].reading_time);
        let date = d.toDateString().split(' ');
        d = date[2] + ' ' + date[1] + ' ' + date[3] + ' '+   d.toTimeString().split(" ")[0];
        timestamp_array.push(d);
    }

    updateGraph(moisture_array, ph_array, temperature_array, intensity_array, timestamp_array);
}

function fetchData(){
    fetch( "http://indocorpolex.com/hello/data.php", {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
        }, 
    })
    .then(data => data.json())
    .then(data => {
        processFetchedData(data);
        console.log(data);
    });
    
}

function createGraph(){
    createMoistureGraph();
    createPHGraph();
    createTemperatureGraph();
    createIntensityGraph();
    fetchData();
}

createGraph();


setInterval(()=>{
    fetchData();
}, 35000);


function setDataForDownload(all_data){
    link_div.style.display = 'block';
    button.innerHTML = 'Generate';
    button.addEventListener('click', generate);
    link.setAttribute("download", "all_data.txt");
    link.setAttribute("href", "data: " + all_data);
    document.getElementById("download_json").setAttribute("download", "all_data.json");
    document.getElementById("download_json").setAttribute("href", "data: " + all_data);
}
function generate(){
    link_div.style.display = 'none';
    button.innerHTML = 'Generating... please wait...';
    button.removeEventListener('click', generate);

    fetch( "http://indocorpolex.com/hello/data.php", {
        headers: {
            'Content-Type': 'application/json',
        }, 
    })
    .then(data => data.json())
    .then(data => {
        const all_data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(data));
        setDataForDownload(all_data);
    });
}

button.addEventListener('click', generate);