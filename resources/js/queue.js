/**
 * 简单的队列实现
 * @author wisp-x<i@wispx.cn>
 * @link https://github.com/wisp-x
 */
class Queue {
    constructor() {
        this.jobs = [];
        this.results = [];

        this.next = function (callback) {
            let self = this;
            new Promise(function (resolve) {
                let fn = self.jobs.shift();
                if (typeof fn === 'function') {
                    fn(resolve);
                }
            }).then(function (result) {
                if (self.onCallback) {
                    self.onCallback(result);
                }

                self.results.push(result);
                if (self.jobs.length === 0) {
                    callback(self.results);
                } else {
                    self.next(callback);
                }
            });
        }
    }

    push(fn) {
        this.jobs.push(fn);
    }

    start(fn) {
        this.next(fn);
    }

    on(fn) {
        this.onCallback = fn;
    }
}

export default Queue;
