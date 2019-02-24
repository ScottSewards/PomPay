/*
window.onload("load", function(){
  if(typeof web3 !== 'undefined') {
    console.log("Web3 found");
    web = new Web3(web3.currentProvider);
  } else {
    console.log('Web3 not found');
    web = new Web3(new Web3.providers.HttpProvider('http://localhost:8545')); //fallback - use your fallback strategy (local node / hosted node + in-dapp id mgmt / fail)
  }

  if(web) {
    if(web.eth.accounts.length) {
      const account = web.eth.accounts[0];
      // updates UI, state, pull data
    } else {
      //window.alert("MetaMask is locked");
    }
  }

  //web.eth.personal.newAccount('testTest').then(console.log);


  if (web3js) {
    switch (web3js.version.network) {
      case '1':
        console.log('This is mainnet');
        break;
      case '2':
        console.log('This is the deprecated Morden test network.');
        break;
      case '3':
        console.log('This is the ropsten test network.');
        break;
      case '4':
        console.log('This is the Rinkeby test network.');
        break;
      case '42':
        console.log('This is the Kovan test network.');
        break;
      default:
        console.log('This is an unknown network.');
    }

    const desiredNetwork = 1;
    if (web3js.version.network !== desiredNetwork) {
      // ask user to switch to desired network
      console.log('Please switch to main network.');
    }
  }
});
*/
