<template>
  <div class="s">
    <h4>Select a Report</h4>
    
    <div class="mb-5">
        <select class="form-control">
            <option>Vacancies and Occupancies</option> <!-- pie chart. 100% properties and number of vacancies -->
            <option>Revenue</option><!-- show amount earned for the year v projected | line | give option to select the date in this view -->
            <option>Maintenance Requests</option>
            <option>Expenditures (coming soon)</option>
        </select>
    </div>

    <line-chart :chart-data="datacollection" :height="100"></line-chart>
  </div>
</template>

<script>

import LineChart from './LineChart.js'

export default {
  components: {
    LineChart
  },
  data(){
    return {
      datacollection: null
    }
  },
  mounted () {
    this.fillData()
  },
  methods: {

    filterReport() {
        
        // based on the users report display the data

        // call the function to get the data

        // pass data to chart

    },

    fillData () {

      this.datacollection = {
        labels: ['Lunes','Martes','Miercoles','Jueves','Viernes', 'Sabado' , 'Domingo'],
        datasets: [
          {
            label: 'Ventas',
            backgroundColor: '#5603ad',
            data: [ 20, 40, 50, 20, 50, 40]
          },
        ]
      }

    }
  }
}
</script>
