// Seleciona o input do CEP
const cepInput = document.getElementById('cepInput');
const cepInput2 = document.getElementById('cepInput2');
const cepInput3 = document.getElementById('cepInput3');

// Adiciona um listener para o evento input
cepInput.addEventListener('input', function() {
    // Chama a função buscarCEP() quando o usuário termina de digitar o CEP
    buscarCEP();
});

cepInput2.addEventListener('input', function() {
  // Chama a função buscarCEP() quando o usuário termina de digitar o CEP
  buscarCEP2();
});

cepInput3.addEventListener('input', function() {
  // Chama a função buscarCEP() quando o usuário termina de digitar o CEP
  buscarCEP3();
});



function buscarCEP(){

	const cep = document.querySelector("input[name=cepuser]");
  console.log("Chegou Aqui")
  cep.addEventListener('blur', e=> {
  		const value = cep.value.replace(/[^0-9]+/, '');
      const url = `https://viacep.com.br/ws/${value}/json/`;
      
      fetch(url)
      .then( response => response.json())
      .then( json => {
      		
          if( json.localidade ) {
          	document.querySelector('input[name=ruauser]').value = json.logradouro;
            document.querySelector('input[name=bairrouser]').value = json.bairro;
            document.querySelector('input[name=cidadeuser]').value = json.localidade;
            document.querySelector('input[name=estadouser]').value = json.uf;
          }
      
      });  
  })}

  function buscarCEP2(){

    const cep2 = document.querySelector("input[name=cepuser2]");
    
    cep2.addEventListener('blur', e=> {
        const value2 = cep2.value.replace(/[^0-9]+/, '');
        const url2 = `https://viacep.com.br/ws/${value2}/json/`;
        
        fetch(url2)
        .then( response => response.json())
        .then( json => {
            
            if( json.localidade ) {
              document.querySelector('input[name=ruauser2]').value = json.logradouro;
              document.querySelector('input[name=bairrouser2]').value = json.bairro;
              document.querySelector('input[name=cidadeuser2]').value = json.localidade;
              document.querySelector('input[name=estadouser2]').value = json.uf;
            }
        
        });  
    })}


    function buscarCEP3(){

      const cep2 = document.querySelector("input[name=cepuser3]");
      
      cep2.addEventListener('blur', e=> {
          const value2 = cep2.value.replace(/[^0-9]+/, '');
          const url2 = `https://viacep.com.br/ws/${value2}/json/`;
          
          fetch(url2)
          .then( response => response.json())
          .then( json => {
              
              if( json.localidade ) {
                document.querySelector('input[name=ruauser3]').value = json.logradouro;
                document.querySelector('input[name=bairrouser3]').value = json.bairro;
                document.querySelector('input[name=cidadeuser3]').value = json.localidade;
                document.querySelector('input[name=estadouser3]').value = json.uf;
              }
          
          });  
      })}