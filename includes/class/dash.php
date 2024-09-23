<?php

function dash()
{

    if (!is_login()) {
        return login();
        return user_not_logged_in();
    }
    $users_id = $_SESSION["users_id"];
    $user = get_client();
    $currency = $user["currency"];
    //   echo $currency;
    //   $currency= $_SESSION["currency"];
    //   echo $currency;

    //   echo $users_id;
    $c = new client();
    //get client data and show 
    // $client_data = $c->get_line_data();
    $client_data = $c->get_line_data();

    // debug_r($client_data);
    $clientId = $client_data['client_id'];
    $spark_line_data = $client_data['spark_line_data'];
    $infobox_headings = $client_data['infobox_headings'];
    $last_data = $client_data['last_data'];
    $infobox = $client_data['infobox'];
    $dates = $client_data['dates'];
    // debug_r($client_data);
    $sql = "select * from client_data where ";
    $heading = 'Dashboard';
    $head = '';
    // if($_GET[""])
    {
    }
    //get_sidebar().


    $temp = get_sidebar() . user_profile() . '
    <div class="col-lg-11 col-md-12">
      <div class="content-area">
        <div class="container-fluid">
          <div class="main">
            <div class="row sparkboxes mt-4">';
    foreach ($infobox_headings as $i => $a) {
        $is_last = ($i === array_key_last($infobox_headings));
        $temp .= '
              <div class="col-md-3">
                <div class="box box' . ($i + 1) . '">
                  <div class="details">';
        if ($i < 3) {
            $temp .= '<h4 style="line-height: 1;">' . $currency . '</h4>';
        }
        $style = $is_last ? 'padding-top: 25px;' : '';
        $temp .= '
                    <h3 style="line-height: 1;' . $style . '">' . $last_data[$i] . '</h3>
                    <h4 style="line-height: 1;">' . $a . '</h4>
                  </div>
                  <div id="spark' . ($i + 1) . '"></div>
                </div>
              </div>';
    }

    $temp .= '
            </div>
            <div class="row mt-4 mb-4">
              <div class="col-md-6">
                <div class="box">
                    <div id="line-adwords"></div>
                </div>
            </div>
              <div class="col-md-6" width="200px"><div class="box"><div id="stacked" style:"padding-right: 50px;" ></div></div></div>
            </div>
            <div class="row mt-5 mb-4">
              <div class="col-md-6"><div class="box"><div id="area"></div></div></div>
              <div class="col-md-6"><div class="box"><div id="donut"></div></div></div>
            </div>
          </div>
        </div>
        <div id="file_cards"></div>
      </div>
    </div>';

    $head_data = '<script>
var data =
{"prices":[7114.25,7126.6,7116.95,7203.7,7233.75,7451.0,7381.15,7348.95,7347.75,7311.25,7266.4,7253.25,7215.45,7266.35,7315.25,7237.2,7191.4,7238.95,7222.6,7217.9,7359.3,7371.55,7371.15,7469.2,7429.25,7434.65,7451.1,7475.25,7566.25,7556.8,7525.55,7555.45,7560.9,7490.7,7527.6,7551.9,7514.85,7577.95,7592.3,7621.95,7707.95,7859.1,7815.7,7739.0,7778.7,7839.45,7756.45,7669.2,7580.45,7452.85,7617.25,7701.6,7606.8,7620.05,7513.85,7498.45,7575.45,7601.95,7589.1,7525.85,7569.5,7702.5,7812.7,7803.75,7816.3,7851.15,7912.2,7972.8,8145.0,8161.1,8121.05,8071.25,8088.2,8154.45,8148.3,8122.05,8132.65,8074.55,7952.8,7885.55,7733.9,7897.15,7973.15,7888.5,7842.8,7838.4,7909.85,7892.75,7897.75,7820.05,7904.4,7872.2,7847.5,7849.55,7789.6,7736.35,7819.4,7875.35,7871.8,8076.5,8114.8,8193.55,8217.1,8235.05,8215.3,8216.4,8301.55,8235.25,8229.75,8201.95,8164.95,8107.85,8128.0,8122.9,8165.5,8340.7,8423.7,8423.5,8514.3,8481.85,8487.7,8506.9,8626.2],
"dates":["02 Jun 2017","05 Jun 2017","06 Jun 2017","07 Jun 2017","08 Jun 2017","09 Jun 2017","12 Jun 2017","13 Jun
2017","14 Jun 2017","15 Jun 2017","16 Jun 2017","19 Jun 2017","20 Jun 2017","21 Jun 2017","22 Jun 2017","23 Jun
2017","27 Jun 2017","28 Jun 2017","29 Jun 2017","30 Jun 2017","03 Jul 2017","04 Jul 2017","05 Jul 2017","06 Jul
2017","07 Jul 2017","10 Jul 2017","11 Jul 2017","12 Jul 2017","13 Jul 2017","14 Jul 2017","17 Jul 2017","18 Jul
2017","19 Jul 2017","20 Jul 2017","21 Jul 2017","24 Jul 2017","25 Jul 2017","26 Jul 2017","27 Jul 2017","28 Jul
2017","31 Jul 2017","01 Aug 2017","02 Aug 2017","03 Aug 2017","04 Aug 2017","07 Aug 2017","08 Aug 2017","09 Aug
2017","10 Aug 2017","11 Aug 2017","14 Aug 2017","16 Aug 2017","17 Aug 2017","18 Aug 2017","21 Aug 2017","22 Aug
2017","23 Aug 2017","24 Aug 2017","28 Aug 2017","29 Aug 2017","30 Aug 2017","31 Aug 2017","01 Sep 2017","04 Sep
2017","05 Sep 2017","06 Sep 2017","07 Sep 2017","08 Sep 2017","11 Sep 2017","12 Sep 2017","13 Sep 2017","14 Sep
2017","15 Sep 2017","18 Sep 2017","19 Sep 2017","20 Sep 2017","21 Sep 2017","22 Sep 2017","25 Sep 2017","26 Sep
2017","27 Sep 2017","28 Sep 2017","29 Sep 2017","03 Oct 2017","04 Oct 2017","05 Oct 2017","06 Oct 2017","09 Oct
2017","10 Oct 2017","11 Oct 2017","12 Oct 2017","13 Oct 2017","16 Oct 2017","17 Oct 2017","18 Oct 2017","19 Oct
2017","23 Oct 2017","24 Oct 2017","25 Oct 2017","26 Oct 2017","27 Oct 2017","30 Oct 2017","31 Oct 2017","01 Nov
2017","02 Nov 2017","03 Nov 2017","06 Nov 2017","07 Nov 2017","08 Nov 2017","09 Nov 2017","10 Nov 2017","13 Nov
2017","14 Nov 2017","15 Nov 2017","16 Nov 2017","17 Nov 2017","20 Nov 2017","21 Nov 2017","22 Nov 2017","23 Nov
2017","24 Nov 2017","27 Nov 2017","28 Nov 2017"]}


var monthDataSeries1 = {
"prices":[8107.85,8128.0,8122.9,8165.5,8340.7,8423.7,8423.5,8514.3,8481.85,8487.7,8506.9,8626.2,8668.95,8602.3,8607.55,8512.9,8496.25,8600.65,8881.1,9340.85],
"dates":["13 Nov 2017","14 Nov 2017","15 Nov 2017","16 Nov 2017","17 Nov 2017","20 Nov 2017","21 Nov 2017","22 Nov
2017","23 Nov 2017","24 Nov 2017","27 Nov 2017","28 Nov 2017","29 Nov 2017","30 Nov 2017","01 Dec 2017","04 Dec
2017","05 Dec 2017","06 Dec 2017","07 Dec 2017","08 Dec 2017"]
}

var monthDataSeries2 = {
"prices":[8423.7,8423.5,8514.3,8481.85,8487.7,8506.9,8626.2,8668.95,8602.3,8607.55,8512.9,8496.25,8600.65,8881.1,9040.85,8340.7,8165.5,8122.9,8107.85,8128.0]
}</script>';
    //get client data and show
    // $spark_line_data = $c->get_line_data();

    if ($infobox)
        $head .= '

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
    -->

<script>


Apex.grid = {
    padding: {
        right: 0,
        left: 0
    }
}

Apex.dataLabels = {
    enabled: false
}

var randomizeArray = function(arg) {
    var array = arg.slice();
    var currentIndex = array.length,
        temporaryValue, randomIndex;

    while (0 !== currentIndex) {

        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

// data for the sparklines that appear below header area
var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];

// the default colorPalette for this dashboard
//var colorPalette = ["#01BFD6", "#5564BE", "#F7A600", "#EDCD24", "#F74F58"];
var colorPalette = ["#00D8B6", "#008FFB", "#FEB019", "#FF4560", "#775DD0"]
' . $spark_line_data . '

var monthlyEarningsOpt = {
    chart: {
        type: "area",
        height: 260,
        background: "#eff4f7",
        sparkline: {
            enabled: true
        },
        offsetY: 20
    },
    stroke: {
        curve: "straight"
    },
    fill: {
        type: "solid",
        opacity: 1,
    },
    series: [{
        data: randomizeArray(sparklineData)
    }],
    xaxis: {
        crosshairs: {
            width: 1
        },
    },
    yaxis: {
        min: 0,
        max: 130

    },
    colors: ["#dce6ec"],

    title: {
        text: "Total Earned",
        offsetX: -30,
        offsetY: 100,
        align: "right",
        style: {
            color: "#7c939f",
            fontSize: "16px",
            cssClass: "apexcharts-yaxis-title"
        }
    },
    subtitle: {
        text: "$135,965",
        offsetX: -30,
        offsetY: 100,
        align: "right",
        style: {
            color: "#7c939f",
            fontSize: "24px",
            cssClass: "apexcharts-yaxis-title"
        }
    }
}

new ApexCharts(document.querySelector("#spark1"), spark1).render();
new ApexCharts(document.querySelector("#spark2"), spark2).render();
new ApexCharts(document.querySelector("#spark3"), spark3).render();
new ApexCharts(document.querySelector("#spark4"), spark4).render();

var users_id = "' . $users_id . '";
var currency = "' . $user["currency"] . '";
console.log(currency);

// --------------------------- 2 bar charts--------------------

var options = {
    series: [{
            name: "Fund\'s NAV",
            data: [' . implode(', ', array_slice($infobox[4], -10)). ']
        },
        {
            name: "Cumulative Dividend",
            data: [' . implode(', ', array_slice($infobox[12], -10)) . ']
        },
    ],
    title: {
    text: "Historical NAV And Profit Distribution",
    align: "left",
    style: {
        fontSize: "16px" , // Adjust this value as needed
    }
},
subtitle: {
    text: "(Per Share)",
    align: "left",
    style: {
        fontSize: "12px" // Adjust the font size as needed
    }
},
    chart: {
        type: "bar",
        height: 350,
        stacked: true,
        toolbar: {
            show: true
        },
        zoom: {
            enabled: true
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            dataLabels: {
                total: {
                    enabled: false,
                    style: {
                        fontSize: "13px",
                        fontWeight: 900
                    }
                }
            }
        },
    },
    grid: {
        show: false,
        padding: {
            top: 20,
        }
    },
    xaxis: {
        type: "category",
        categories: ["' . implode('", "', array_slice($dates, -10)) . '"],
        labels: {
            formatter: function(value) {
                var date = new Date(value);
                var day = date.getDate();
                var month = date.toLocaleString("default", {
                    month: "short"
                });
                var year = date.getFullYear().toString().slice(-2);
                return day + " " + month + " " + year;
            } 
        }
    },
    yaxis: {
        labels: {
            padding:10,
            formatter: function(value) {
                // Using currency in the label formatting
                return currency + " " + value.toLocaleString();
            }
        }
    },

    tooltip: {
        x: {
            formatter: function(value) {
                return new Date(value).toLocaleString("default", {
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                });
            }
        }
    },

    legend: {
        position: "top",
        horizontalAlign: "right",
        offsetY: 10
    },
    fill: {
        opacity: 1
    }
};
// Set the minimum y-axis value based on the data
options.yaxis.min = Math.min.apply(Math, options.series[0].data) > 500 ? 800 : 0;

var chart = new ApexCharts(document.querySelector("#stacked"), options);
chart.render();
// --------------------------- 2 bar charts--------------------


var optionsLine = {
    series: [
        {
            name: "Fund\'s NAV",
            data: [' . implode(', ', array_slice($infobox[4], -10)) . ']
        },
        {
            name: (currency === "AED") ? "PP" : "TASI",
            data: [' . implode(', ', array_slice($infobox[5], -10)) . ']
        },
        {
            name: "S&P 500",
            data: [' . implode(', ', array_slice($infobox[6], -10)) . ']
        }
    ],
    title: { 
        text: "Net Asset Value (NAV) Performance",
        align: "left",
        style: {
        fontSize: "16px" , // Adjust this value as needed
    }
    },
    chart: {
        height: 350,
        type: "line",
        zoom: {
            enabled: true
        }
    },
    stroke: {
        curve: "smooth",
        width: 3
    },
    markers: {
        size: 6,
        strokeWidth: 0,
        hover: {
            size: 9
        }
    },
    grid: {
        show: true,
        padding: {
            left: 20,
            right: 20,
        }
    },
    labels: ["' . implode('", "', array_slice($dates, -10)) . '"],
    xaxis: {
        type: "date",
        labels: {
            formatter: function(value) {
                var date = new Date(value);
                var day = date.getDate();
                var month = date.toLocaleString("default", {
                    month: "short"
                });
                var year = date.getFullYear().toString().slice(-2);
                return day + " " + month + " " + year;
            }
        },
        tooltip: {
            enabled: false,
        }
    },
    yaxis: {
        labels: {
            padding: 10,
            formatter: function(value) {
                // Using currency in the label formatting
                return currency + " " + value.toLocaleString();
            }
        }
    },
    legend: {
        position: "top",
        horizontalAlign: "right",
        offsetY: 10
    }
};

var chartLine = new ApexCharts(document.querySelector("#line-adwords"), optionsLine);
chartLine.render();



var options = {
    series: [{
        name: "Realized Gain/(Loss)",
        data: [' . implode(', ', array_slice($infobox[10], -10)) . ']
    }],
    chart: {
        height: 350,
        type: "area"
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: "smooth"
    },
    title: {
        text: "Realized Gain/(Loss)",
        align: "left",
        style: {
        fontSize: "16px" , // Adjust this value as needed
    }
    },
    labels: ["' . implode('", "', array_slice($dates, -10)) . '"],
    xaxis: {
        type: "date",
        labels: {
            formatter: function(value) {
                var date = new Date(value);
                var day = date.getDate();
            var month = date.toLocaleString("default", {
                    month: "short"
                });
                var year = date.getFullYear().toString().slice(-2);
            return day + " " + month + " " + year;
            }
        },
        tooltip: {
            enabled: false,
        }
    },
    yaxis: {
        labels: {
            padding: 10,
            formatter: function(value) {
                var suffixes = ["", "K", "M", "B"]; // Array of suffixes for thousand, million, billion, etc.
                var suffixIndex = 0;
                
                // Determine sign and work with absolute value
                var absValue = Math.abs(value);
                
                // Convert value to appropriate scale (K, M, B, etc.)
                while (absValue >= 1000 && suffixIndex < suffixes.length - 1) {
                    absValue /= 1000;
                    suffixIndex++;
                }
                
                // Round to whole number
                absValue = Math.round(absValue);
                
                var formattedValue = absValue + suffixes[suffixIndex];
                
                // Add sign to formatted value
                if (value < 0) {
                    formattedValue =  currency + " " + "-" + formattedValue;
                } else {
                    formattedValue = currency + " " + formattedValue;
                }
                
                return formattedValue;
            }
        }
    },
};

var chart = new ApexCharts(document.querySelector("#area"), options);
chart.render();

// ----------------------------------------dontu--------------------------

var options = {
    series: [{
        name: "Dividend per Share",
        data: [' . implode(', ', array_slice($infobox[12], -10)) . ']
    }],
    chart: {
        height: 350,
        type: "line",
    },
    forecastDataPoints: {
        count: 0
    },
    stroke: {
        width: 5,
    },
    labels: ["' . implode('", "', array_slice($dates, -10)) . '"],
    xaxis: {
        type: "date",
        labels: {
            formatter: function(value) {
                var date = new Date(value);
                var day = date.getDate();
                var month = date.toLocaleString("default", {
                    month: "short"
                });
                var year = date.getFullYear().toString().slice(-2);
                return day + " " + month + " " + year;
            }
        },
        tooltip: {
            enabled: false,
        }
    },

    yaxis: {
        labels: {
            padding: 10,
            formatter: function(value) {
                // Using currency in the label formatting
                return currency + " " + value.toLocaleString();
            }
        }
    },
    title: {
    text: "Cumulative Profit Distribution ",
    align: "left",
    style: {
        fontSize: "16px" , // Adjust this value as needed
    }
},
subtitle: {
    text: "(Per Share)",
    align: "left",
    style: {
        fontSize: "12px" // Adjust the font size as needed
    }
},
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            gradientToColors: ["#FDD835"],
            shadeIntensity: 1,
            type: "horizontal",
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        },
    }
};

var chart = new ApexCharts(document.querySelector("#donut"), options);
chart.render();


</script>



<style>

.box {
    /*background-color: #2B2D3E;*/
     padding: 10px;
    margin: 10px;
    width: fit-content(20em);
}

.shadow {
    box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
}

.sparkboxes .box {
    padding-top: 5px;
    padding-bottom: 20px;
    text-shadow: 0 1px 1px 1px #666;
    box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
    position: relative;
    border-radius: 5px;
}

.sparkboxes .box .details {
    // color:black;
    position: absolute;
    color: #fff;
    transform: scale(0.7) translate(-9px, -10px);
    
}

.sparkboxes strong {
    position: relative;
    z-index: 3;
    top: -8px;
    color: #fff;
}

.sparkboxes .box1 {
    background-image: linear-gradient(135deg, #ABDCFF 10%, #0396FF 100%);
}

.sparkboxes .box2 {
    background-image: linear-gradient(135deg, #2AFADF 10%, #4C83FF 100%);
}

.sparkboxes .box3 {
    background-image: linear-gradient(135deg, #FFD3A5 10%, #FD6585 100%);
}

.sparkboxes .box4 {
    background-image: linear-gradient(135deg, #EE9AE5 10%, #5961F9 100%);
}

.row.sparkboxes.mt-4 h4 {
    font-weight: bold;
    font-size: 18px;
    line-height: 19px;
}
</style>';
    $data_n = array();
    $data_n["html_head"] = "";
    $data_n["html_title"] = $heading;
    $data_n["html_heading"] = $heading;
    $data_n['html_text'] = wrap_form($temp, '', '');
    $data_n["html_head"] = $head;
    return $data_n;
}
