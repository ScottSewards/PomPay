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
      console.log("Your Ethereum address is " + account);
      var promise1 = new Promise(function(resolve, reject) {
        setTimeout(function() {
          resolve('foo');
        }, 300);
      });

      web3.eth.getAccounts(function (err, accounts) {
        web.eth.getBalance(accounts[0], function (err, balance) {
          console.log('Your balance is ' + web3.fromWei(balance, 'ether'));
        })
      })
    } else {
      console.log("Your account is locked.");
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
