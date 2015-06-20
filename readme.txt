#######################################
#Very basic barebones bitcoin faucet  #
#Uses blockchain.info to send payments#
#######################################

1. Create a blockchain.info wallet, this faucet requires an account
2. Enable API access on blockchain.info settings AND whitelist your servers IP
3. Goto the cashout.php page and insert your blockchain.info USER ID and Password
4. You can change the cashout requirements on the cashout.php page
5. You can change the reward amount and time to wait between claims on the member.php page.
6. Create a mysql database and create a table named 'users' with FOUR(4) columns:
   -  user  (VARCHAR)  17  Unique
   -  pw     (VARCHAR) 50
   -  balance  (INT)   Default as defined 100
   -  time     (INT)   75

Video step by step tutorial on creating this mysql database and source code is available at https://www.youtube.com/watch?v=ZEQUfPleqaI