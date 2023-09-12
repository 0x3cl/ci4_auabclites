import { get_overview, get_visitors, get_referrers } from "./data.js";

export function site_overview() {
  get_overview()
    .then((response) => {
        // Check if the response status is 200 and the message is 'ok'
        if (response.status === 200 && response.message === 'ok') {
          const dom = `
          <div class="row mt-4">
            <div class="col-6 col-md-4 mb-2 mb-md-3">
                <div class="card orange">
                    <div class="card-header border-0 bg-transparent">
                        Total Users
                    </div>
                    <div class="card-body">
                        <h1 class="m-0">`+response.data.total_users+`</h1>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 mb-2 mb-md-3">
                <div class="card green">
                    <div class="card-header border-0 bg-transparent">
                        Total Visitors
                    </div>
                    <div class="card-body">
                        <h1 class="m-0">`+response.data.total_visitors+`</h1>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 mb-2 mb-md-3">
                <div class="card blue">
                    <div class="card-header border-0 bg-transparent">
                        Total Bulletin
                    </div>
                    <div class="card-body">
                        <h1 class="m-0">`+response.data.total_bulletin+`</h1>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 mb-2 mb-md-3">
                <div class="card violet">
                    <div class="card-header border-0 bg-transparent">
                        Total Faculty
                    </div>
                    <div class="card-body">
                        <h1 class="m-0">`+response.data.total_faculty+`</h1>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 mb-2 mb-md-3">
                <div class="card red">
                    <div class="card-header border-0 bg-transparent">
                        Total Officers
                    </div>
                    <div class="card-body">
                        <h1 class="m-0">`+response.data.total_officers+`</h1>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 mb-2 mb-md-3">
                <div class="card dark-blue">
                    <div class="card-header border-0 bg-transparent">
                        Total Research
                    </div>
                    <div class="card-body">
                        <h1 class="m-0">`+response.data.total_research+`</h1>
                    </div>
                </div>
            </div>
          `;

          $('#overview-dom').html(dom);
        }
    })
}

export function site_visitor_graph() {

// Initialize arrays for month and count data
let selected_year;
let month = [];
let count = [];
let datasets = [];

// Retrieve visitor data asynchronously
get_visitors()
  .then((response) => {
    // Get the selected year
    selected_year = new Date().getFullYear();

    // Check if the response status is 200 and the message is 'ok'
    if (response.status === 200 && response.message === 'ok') {
      for(let key in response.data) {
        const data = {
          label: `${key} VISITORS`,
          data: Object.values(response.data[key]),
          backgroundColor: '#801313',
          borderColor: '#801313',
          borderWidth: 1
        }
        datasets.push(data);
      }

      // Extract data for the selected year
      const data = response.data[selected_year];

      // Populate month and count arrays using the data
      month.push(...Object.keys(data));
      count.push(...Object.values(data));
    }
  })
  .then(() => {
    $('#graph-line-dom').html(`
    <div class="card-body">
      <canvas id="site-visitor"></canvas>
    </div>
    `);

    // Select the canvas element by its ID
    const ctx = $('canvas#site-visitor');

    
    // Create a Chart.js chart
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: month,
        datasets: datasets
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
}

export function site_referrer_graph() {
  let referrer = []; 
  let count = [];
  get_referrers().then((response) => {
      if (response.status === 200 && response.message === 'ok') {
        referrer.push(...Object.keys(response.data));
        for(let key in response.data) {
          count.push(response.data[key].count);
        }
      }
  }).then(() => {

    $('#graph-bar-dom').html(`
    <div class="card-body">
      <canvas id="site-referrer"></canvas>
    </div>
    `);

    const ctx = $('canvas#site-referrer ');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: referrer,
          datasets: [{
            label: 'Site Referrers',
            data: count,
            backgroundColor:  '#801313',
            hoverOffset: 4
          }]
        },
        options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
        }
    }) 
});
}
