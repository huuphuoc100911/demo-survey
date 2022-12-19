<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>The Survey Page </title>

        <!-- Your platform (jquery) scripts. -->
        <link href="https://surveyjs.azureedge.net/1.0.28/survey.css" type="text/css" rel="stylesheet" />

    </head>

    <body>
        <div id="surveyContainer"></div>        
    </body>
    <script src="https://surveyjs.azureedge.net/1.0.28/survey.jquery.min.js"></script>
    <script>
        alert("This is the survey blade right here right now");
        var surveyJSON = {pages:[{name:"page1",elements:[{type:"paneldynamic",name:"question2",templateElements:[{type:"radiogroup",name:"question3",choices:["item1","item2","item3"]},{type:"text",name:"question4"}]},{type:"paneldynamic",name:"question1"}]}]}

        function sendDataToServer(survey) {
            //send Ajax request to your web server later. Meantime...
            alert("The results are:" + JSON.stringify(survey.data));
        }

        var survey = new Survey.Model(surveyJSON);
        $("#surveyContainer").Survey({
            model: survey,
            onComplete: sendDataToServer
        });
    </script>
</html>