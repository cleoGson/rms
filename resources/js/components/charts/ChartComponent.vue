<script>
import { Line,Bar } from 'vue-chartjs';

export default {
   extends: Bar,
   mounted() {
         let Years = new Array();
         let Labels = new Array();
         let Prices = new Array();
        axios.get('/coins').then((response) => {
            let data = response.data;
            if(data) {
               data.forEach(element => {
               Years.push(element.year);
               Labels.push(element.name);
               Prices.push(element.price);
               });
               this.renderChart({
               labels: Years,
               datasets: [{
                  label: Labels[0],
                  backgroundColor: '#FC2525',
                  data: Prices
            }]
         }, 
         {responsive: true, maintainAspectRatio: false})
       }
       else {
          console.log('No data');
       }
      });            
   }
}
</script>