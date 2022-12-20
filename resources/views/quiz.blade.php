<!DOCTYPE html>
<html>

<head>
    <title>SurveyJS for jQuery - Quiz Survey</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>
    {{-- <script type="text/javascript" src="/js/survey.js"></script> --}}
</head>

<body>
    <div id="surveyContainer"></div>
    <div id="resultsContainer" style="display:none;">
        <p>Result JSON:</p>
        <code id="surveyResults" style="white-space:pre;"></code>
    </div>
</body>
<script>
    Survey.StylesManager.applyTheme("defaultV2");

    // const surveyJson = {
    //     title: "American History",
    //     pages: [{
    //         elements: [{
    //             type: "radiogroup",
    //             name: "civilwar",
    //             title: "When was the American Civil War?",
    //             choices: [
    //                 "1796-1803", "1810-1814", "1861-1865", "1939-1945"
    //             ],
    //             correctAnswer: "1861-1865"
    //         }]
    //     }, {
    //         elements: [{
    //             type: "radiogroup",
    //             name: "libertyordeath",
    //             title: "Whose quote is this: \"Give me liberty, or give me death\"?",
    //             choicesOrder: "random",
    //             choices: [
    //                 "John Hancock", "James Madison", "Patrick Henry", "Samuel Adams"
    //             ],
    //             correctAnswer: "Patrick Henry"
    //         }]
    //     }, {
    //         elements: [{
    //             type: "radiogroup",
    //             name: "magnacarta",
    //             title: "What is Magna Carta?",
    //             choicesOrder: "random",
    //             choices: [
    //                 "The foundation of the British parliamentary system",
    //                 "The Great Seal of the monarchs of England",
    //                 "The French Declaration of the Rights of Man",
    //                 "The charter signed by the Pilgrims on the Mayflower"
    //             ],
    //             correctAnswer: "The foundation of the British parliamentary system"
    //         }]
    //     }]
    // };

    const surveyJson = {
        title: "American History",
        pages: [{
            elements: [{
                type: "radiogroup",
                name: "civilwar",
                title: "When was the American Civil War?",
                choices: [
                    "1796-1803", "1810-1814", "1861-1865", "1939-1945"
                ],
                correctAnswer: "1861-1865"
            }]
        }, {
            elements: [{
                type: "radiogroup",
                name: "libertyordeath",
                title: "Whose quote is this: \"Give me liberty, or give me death\"?",
                choicesOrder: "random",
                choices: [
                    "John Hancock", "James Madison", "Patrick Henry", "Samuel Adams"
                ],
                correctAnswer: "Patrick Henry"
            }]
        }, {
            elements: [{
                type: "radiogroup",
                name: "magnacarta",
                title: "What is Magna Carta?",
                choicesOrder: "random",
                choices: [
                    "The foundation of the British parliamentary system",
                    "The Great Seal of the monarchs of England",
                    "The French Declaration of the Rights of Man",
                    "The charter signed by the Pilgrims on the Mayflower"
                ],
                correctAnswer: "The foundation of the British parliamentary system"
            }]
        }]
    };




    const survey = new Survey.Model(surveyJson);

    survey.start();

    survey.startTimer();
    survey.stopTimer();

    function displayResults(sender) {
        const results = JSON.stringify(sender.data, null, 4);
        console.log(results);
        document.querySelector("#surveyResults").textContent = results;
        document.querySelector("#resultsContainer").style.display = "block";
        $.ajax({
            url: "{{ route('user.postDemo') }}",
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "inputs": results
            },
            success: function(response) {
                console.log(response);
            }
        });
    }

    survey.onComplete.add(displayResults);

    $(function() {
        $("#surveyContainer").Survey({
            model: survey
        });
    });
</script>

</html>
