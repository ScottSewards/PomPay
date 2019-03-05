window.onload = function() {
  if(typeof web3 !== 'undefined') { //CHECK FOR Web3
    console.log("Web3 found");
    web = new Web3(web3.currentProvider);
  } else {
    console.log('Web3 not found');
    web = new Web3(new Web3.providers.HttpProvider('http://localhost:8545')); //fallback - use your fallback strategy (local node / hosted node + in-dapp id mgmt / fail)
  }

  if(web) { //GET FIRST ACCOUNT
    if(web.eth.accounts.length) {
      const account = web.eth.accounts[0];
      // updates UI, state, pull data
    } else {
      console.log("Account is locked");
    }
  }

  if(web3) {
    switch (web3.version.network) {
      case '1':
        console.log('This is main network');
        break;
      case '2':
        console.log('This is the deprecated Morden test network');
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

    const desiredNetwork = 1;
    if (web3.version.network != desiredNetwork) {
      // ask user to switch to desired network
      console.log('Please switch to main network');
    }
  }
};

function GenerateAccount() {
  //web.eth.personal.newAccount('testTest').then(console.log);
}

function Send(amount, from, to) {

}
