import $ from "jquery";
import "jquery-ui-dist/jquery-ui.css";

import "survey-jquery/defaultV2.css";

require("jquery-ui-dist/jquery-ui.js");

import * as SurveyCore from "survey-jquery";
import * as widgets from "surveyjs-widgets";

const browserHistory = require('browser-history');
console.log(browserHistory);

// const BrowserHistory = require('node-browser-history');
// getAllHistory(10).then(function (history) {
//   console.log(history);
// });

widgets.jqueryuidatepicker(SurveyCore);

