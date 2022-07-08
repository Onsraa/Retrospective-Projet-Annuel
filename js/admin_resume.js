window.onload = function() {
    for (i = 0; i < datas.length; i++){  
        const keys = Object.keys(datas[i]).reverse();
        const values = Object.values(datas[i]).reverse();

        var dataPoints = [];
        var y = 0;
        for(j = 7; j >= 0; j--)
        {
            if(typeof values[j] == 'undefined')
            {
                values[j] = 0;
            }
            dataPoints.push({y: values[j], label: keys[j]});
        }

        var title = "";
        var subtitles = "";
        switch(i)
        {
            case 0: title = "Number of registered users"; subtitle = "(7 days)"; break;
            case 1: title = "Number of posts online"; subtitle ="(7 days)"; break;
            case 2: title = "Total number of medias"; subtitle = "(7 days)"; break;
        }

        const randomColor = Math.floor(Math.random()*16777215).toString(16);

        var chart = new CanvasJS.Chart(pos[i],
        {
            title:{
                text: title    
            },
            subtitles:[{
                text: subtitle,
                fontColor: "#5A5A5A",
                fontSize: 18
            }],
            legend: {
                verticalAlign: "bottom",
                horizontalAlign: "center"
            },
            data: [
            {        
                color: "#" + randomColor,
                type: "column",  
                dataPoints: dataPoints                
            }
            ]
        });
        chart.render();
        console.log(chart);
    };
}
