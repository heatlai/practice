from random import randint

answer = randint(1, 100)
print('猜數字 1~100 選個數字吧!')

def guess():
    value = input(">>> Enter a number or q to leave: ")
    if value == "q":
        exit()
    if value == 'a':
        print('The answer is ' + str(answer))
        return

    x = int(value)
    if x > answer:
        print('小一點!')
    elif x < answer:
        print('大一點!')
    else:
        print('You win!')
        exit()
        
while True:
    guess()