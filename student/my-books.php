<?php 
include './including/nav.php';
echo '<script>document.username="' . $_SESSION['student_username'] . '"</script>';
?>
  
  <div class="wrapper">

    <div class="message-wrapper">
      <!--<div class="error">
        Please enter a valid email address!
      </div>-->
    </div>
  
    <div class="schedule-container">
    <input type="search" id="searchBar" class="textbox3" placeholder='Search....'>

      <!--
      <div class="schedule-card">
        <span class="schedule-card-batch">43937084303</span>
        <span class="schedule-card-lect">Dark Knight Rises Rises Rises</span>
        <div class="schedule-card-footer">
          <span class="schedule-card-day">Christopher Nolan</span>
          <span class="schedule-card-time">2008</span>
          <span class="schedule-card-luname">andre29</span>
        </div>
      </div>

      <div class="schedule-card">
        <span class="schedule-card-batch">XXXXXX</span>
        <span class="schedule-card-lect">XXXXXXXXXXXX</span>
        <div class="schedule-card-footer">
          <span class="schedule-card-day">XXXXXXX</span>
          <span class="schedule-card-time">XXXXX</span>
          <span class="schedule-card-luname">XXXX</span>
        </div>
      </div>
      -->
    </div>

    <div id="slider" class="slider hide">
      <div>
        <h1></h1>
        <h1>DETAILS</h1>
        <i class="far fa-times-circle editclose"></i>
      </div>
      <div>
        <input id='isbn' label='ISBN' name="isbn" type="text" class="textbox4" disabled>
        <input id='title' label='TITLE' name="title" type="text" class="textbox4" disabled>
        <input id='author' label='AUTHOR' name="author" type="text" class="textbox4" disabled>
        <input id='year' label='YEAR' name="year" type="text" class="textbox4" disabled>
        <input id='date' label='BORROWED DATE' name="b_date" type="text" class="textbox4" disabled>
      </div>
      <div>
        <button class="btn-light" name='return' style='grid-column-start: 1; grid-column-end: 3;'>RETURN</button>
      </div>
    </div>
  </div>


  <script src='../including/script.js'></script>
  <script>
  load(document.username,'');
  function load(uname,search){
    sqlQuery('including/book-list.php',{uname:uname,search:search},()=>{
      document.querySelectorAll('.schedule-card').forEach(item => item.remove());
      let json = response;
      console.log(json);
      let wrapper = document.querySelector('.schedule-container');
      for(var row of json){
        document.search = search;
        var card = document.createElement('div');
        card.className = 'schedule-card';
        var isbn = document.createElement('span');
        isbn.className = 'schedule-card-batch';
        isbn.textContent = row['isbn'];
        var title = document.createElement('span');
        title.className = 'schedule-card-lect'
        title.textContent = row['title'];
        var footer = document.createElement('div');
        footer.className = 'schedule-card-footer';
        var date = document.createElement('span');
        date.className = 'schedule-card-day';
        date.textContent = row['date'];
        
        card.object = row;
        card.onclick = click;
        card.oncontextmenu = contextMenu;
        card.appendChild(isbn);
        card.appendChild(title);
        card.appendChild(footer);
        footer.appendChild(date);
        wrapper.appendChild(card);
      }
    });
  }

  function cardClick(object){
    document.querySelector('[name=isbn]').value = object['isbn'];
    document.querySelector('[name=title]').value = object['title'];
    document.querySelector('[name=author]').value = object['author'];
    document.querySelector('[name=year]').value = object['year'];
    document.querySelector('[name=b_date]').value = object['date'];
    document.querySelector('#slider').classList.remove('hide');
  }

  function click(){ cardClick(this.object) }

  function contextMenu(e){
    e.preventDefault();
    let item1 = document.createElement('div');
    item1.textContent = 'View Details';
    item1.onclick = () => cardClick(this.object);
    showContext(e, item1);
  }


  let search = document.querySelector('#searchBar');
  search.addEventListener('keydown',(e)=>{
    if(e.keyCode == 13){
      load(document.username,search.value);
    }
  });

  document.querySelector('[name=return]').onclick = ()=>{
    sqlQuery('including/book-return.php',{uname:document.username,isbn:document.querySelector('[name=isbn]').value},()=>{
      console.log(response);
      if(response.success){
        document.querySelector('#slider').classList.add('hide');
        document.search ? load(document.username,document.search) : load(document.username,'');
        showSuccess(response.success);
      }else if(response.error){
        showError(response.error);
      }
    });
  };

  </script>

</body>
</html>