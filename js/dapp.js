window.onload = function() {
  if(typeof web3 !== 'undefined') { //CHECK FOR Web3
    console.log("Web3 found.");
    web = new Web3(web3.currentProvider); //SET PROVIDER
  } else {
    console.log('Web3 not found.');
    web = new Web3(new Web3.providers.HttpProvider('http://localhost:8545')); //SET LOCALHOST PROVIDER
  }

  if(web) {
    if(web.eth.accounts.length) {
      const account = web.eth.accounts[0]; //GET FIRST ACCOUNT
      console.log(account);
    } else {
      console.log("Account is locked");
    }
  }

  if(web3) {
    switch (web3.version.network) { //CHECK ETHEREUM NETWORK
      case '1':
        console.log('This is main network.');
        break;
      case '2':
        console.log('This is the deprecated Morden test network.' + message);
        break;
      case '3':
        console.log('This is the ropsten test network');
        break;
      case '4':
        console.log('This is the Rinkeby test network');
        break;
      case '42':
        console.log('This is the Kovan test network');
        break;
      default:
        console.log('This is an unknown network');
    }
  }
};
