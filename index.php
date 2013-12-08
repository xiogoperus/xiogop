<?php 

echo sum(2,6) . "<br>";
echo sum(6,8) . "<br>";
echo sum(16,9) . "<br>";
print sum(3,4) . "<br>";

function alfa()
{
	return 5;
}
function sum($a, $b)
{
	return $a + $b + alfa();
}