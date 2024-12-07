$("#edit-plan-form").validate({
    rules: {
        tradeName: {
            required: true,

        },
        price: {
            required: true,
            number: true
        },
        commission:{
            required : true,
            number : true
        },
        levelCommissions:{
            required : true,
            number : true
        },
        roi : {
            required : true,
            number : true
        }
    },
    messages: {
        tradeName: {
            required: " Please enter plan name",
        },

        price: {
            required: "Please enter plan price",
        },
        commission : {
            required: "Please enter direct commission in %",
        },
        levelCommissions : {
            required: "Please enter direct commission in %",
        },
        roi : {
           required: "Please enter ROI in %",

        }
    }

});
