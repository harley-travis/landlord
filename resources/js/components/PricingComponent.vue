<template>
    <div class="">
       <form>

            <div class="form-group">
                <label>Number of Properties</label>
                <input type="text" class="form-control" name="numberOfProperties" v-model.number="numberOfProperties">
            </div>

            <div class="form-group">
                <label>Enter the highest lease amount</label>
                <input type="text" class="form-control" name="highestLeaseAmount" v-model.number="highestLeaseAmount">
                <small>Do not type in the dollar symbol or commas. Just the amount. EX for $1,000 you would type in 1000.</small>
            </div>

            <p class="text-success font-weight-bold"><strong>Total:</strong> ${{ ((((numberOfProperties * highestLeaseAmount) * 0.0025) + 3) *.5 + (((numberOfProperties * highestLeaseAmount) * 0.0025) + 3)) < 200 ? 200 : Math.round(((numberOfProperties * highestLeaseAmount) * 0.0025) + 3) *.5 + (((numberOfProperties * highestLeaseAmount) * 0.0025) + 3) * 100 / 100 }}</p>

       </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                numberOfProperties: 0,
                highestLeaseAmount: 0,
            }
        },
        methods: {

            sumNumbers() {
                console.log('hi')
            },

        },
    }
</script>
