new Vue ({
    el: "#app",
    data: {
       a:0,
       b:0,
       salary:100
     },
    computed: {
      addToa(){
          console.log("A");
          return this.a+this.salary;
      },
      addTob(){
          console.log('B');
          return this.b+this.salary;
      }
    },
})