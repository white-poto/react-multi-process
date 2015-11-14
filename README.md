react-multi-process
=========================
multi process support to reactphp

Why use react-multi-process
-----------------------------
When we use `react/event-loop` to write async programs, we can not be sure 
that every module is a no-blocking module(async mysql client...).  
So we use multi process to improve the performance of our sync program.
