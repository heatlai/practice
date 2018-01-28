class Account:
    # 初始化
    def __init__(self, name, balance):
        self.name = name
        self.balance = balance
        print("Hello {name}, 您的開戶金額是NT$ {balance} 元".format(name = self.name,balance = self.balance))

    # 存款
    def deposit(self, amount):
        if amount <= 0:
            print("Hello {name}, 請輸入正確的金額".format(name = self.name))
            return self.balance
        self.balance += amount
        print("Hello {name}, 您存了 NT$ {amount} 元, 餘額 NT$ {balance} 元".format(name = self.name,amount = amount,balance = self.balance))
        return self.balance

    # 提款
    def withdraw(self, amount):
        if amount <= self.balance:
            self.balance -= amount
            print("Hello {name}, 您提了 NT$ {amount} 元, 餘額 NT$ {balance} 元".format(name = self.name,amount = amount,balance = self.balance))
            return self.balance
        else:
            print("Hello {name}, 您的存款不足 , 餘額 NT$ {balance} 元".format(name = self.name,balance = self.balance))
            return self.balance

memberA = Account('Leo', 100)
memberA.withdraw(50)
memberA.withdraw(500)
memberA.deposit(1000)